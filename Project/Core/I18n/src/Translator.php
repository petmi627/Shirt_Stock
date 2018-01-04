<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 30.12.17
 * Time: 01:33
 */

namespace App\Core\I18n;


class Translator
{
    private $translatation = [];

    private $config;

    public function __construct($config)
    {
        $this->config = $config;

        $this->setTranslation();
    }

    private function getLanguage()
    {
        $lang = null;

        if (isset($_COOKIE["language"])) {
            $lang = $_COOKIE["language"];
        }

        if (!in_array($lang, $this->config['i18n']['allowedLanguages'])) {
            $lang = $this->config['i18n']['defaultLanguage'];
        }

        return $lang;
    }

    public function setTranslation()
    {
        $translation = $this->config["translator"];

        foreach ($this->config['i18n']['allowedLanguages'] as $language) {
            foreach ($translation["path"] as $path) {
                $pattern = sprintf($translation["pattern"][0], $this->getLanguage());
                $location = $path . $pattern;

                if (!file_exists($location)) {
                    $trans[$language] = null;
                } else {
                    $entries = include($location);
                    $trans[$language] = $entries;
                }

                $this->translatation = array_merge_recursive($trans, $this->translatation);
            }
        }
    }

    public function translate($name)
    {
        if (!isset($this->translatation[$this->getLanguage()][$name])) {
            return $name;
        }

        return $this->translatation[$this->getLanguage()][$name];
    }

    public function translatePlural($singular, $plural, $index)
    {
        if ($index > 1) {
            if (!isset($this->translatation[$this->getLanguage()][$plural])) {
                return $plural;
            }

            return $this->translatation[$this->getLanguage()][$plural];
        }

        if (!isset($this->translatation[$this->getLanguage()][$singular])) {
            return $singular;
        }

        return $this->translatation[$this->getLanguage()][$singular];
    }
}