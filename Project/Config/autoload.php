<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 23.11.17
 * Time: 13:52
 *
 * An example of a project-specific implementation.
 * It use the PSR-4 Standard
 * Code can be found on: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 *
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
 * from /path/to/project/src/Baz/Qux.php:
 *
 *      new \Foo\Bar\Baz\Qux;
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {
    $autoload = false;

    $namespaces = include 'core.php';
    $namespaces = $namespaces["core"]["namespaces"];

    $modules = include 'modules.php';
    $modules = $modules["modules"]["namespaces"];

    $namespaces = array_merge($namespaces, $modules);

    // does the class use the namespace prefix?
    foreach ($namespaces as $namespace => $dir) {
        $len = strlen($namespace);

        if (strncmp($namespace, $class, $len) !== 0) {
            // no, move to the next registered autoloader
            $autoload = false;

            //Continue Loop
            continue;
        }

        $autoload = true;
        $relative_class = substr($class, $len);

        // replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        $file = PROJECT_ROOT . "/" .  $dir . str_replace('\\', '/', $relative_class) . '.php';

        //Break Loop
        break;
    }

    if (!$autoload) {
        // no, move to the next registered autoloader
        return;
    }

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    } else {
        throw new Exception("File $file with class $relative_class not found");
    }
});
