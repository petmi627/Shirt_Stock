<?php

return [
    'router' => [
        'routes' => [
            'index' => [
                'options' => [
                    'route'   => 'home',
                    'defaults' => [
                        'controller' => Application\Controller\IndexController::class,
                        'method'     => 'index',
                    ]
                ],
            ]
        ]
    ],

    'controller' => [
        'factories' => [
            Application\Controller\IndexController::class => Application\Controller\IndexControllerFactory::class,
        ],
    ],

    'service' => [
        'factories' => [

        ],
    ],

    "translator" => [
        'path'      => APPLICATION_MODULE_ROOT . "/language",
        'pattern'   => '/%s.php'
    ]
];
