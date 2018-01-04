<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 22.12.17
 * Time: 20:15
 */

return [
    'router' => [
        'routes' => [
            'shirts-rest' => [
                'options' => [
                    'route'   => 'rest',
                    'defaults' => [
                        'controller' => \Shirts\Controller\ShirtRestController::class,
                    ]
                ],
            ],
            'shirts-frontend' => [
                'options' => [
                    'route'   => 'shirts',
                    'defaults' => [
                        'controller' => \Shirts\Controller\ShirtController::class,
                        'method'     => 'index',
                    ]
                ],
            ],
            'shirts-modify' => [
                'options' => [
                    'route'   => 'shirts-modify',
                    'defaults' => [
                        'controller' => \Shirts\Controller\ShirtController::class,
                    ]
                ],
            ]
        ]
    ],

    'controller' => [
        'factories' => [
            \Shirts\Controller\ShirtController::class => \Shirts\Controller\ShirtControllerFactory::class,
            \Shirts\Controller\ShirtRestController::class => \Shirts\Controller\ShirtRestControllerFactory::class,
        ],
    ],

    'service' => [
        'factories' => [
            Shirts\Repository\ShirtRepository::class => \Shirts\Repository\ShirtRepositoryFactory::class,
        ],
    ],


    "translator" => [
        'path'      => SHIRT_MODULE_ROOT . "/language",
        'pattern'   => '/%s.php'
    ],
];