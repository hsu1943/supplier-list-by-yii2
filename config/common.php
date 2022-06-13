<?php

$params = require __DIR__ . '/params.php';
if (is_file(__DIR__ . '/params-local.php')) {
    $params = \yii\helpers\ArrayHelper::merge($params, require __DIR__ . '/params-local.php');
}
$router = require __DIR__ . '/router.php';

$config = [
    'id'         => 'app',
    'name'       => 'YinHao',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'components' => [
        'cache'      => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => false,
            'baseUrl'             => '/',
            'rules'               => $router,
        ],
        'log'        => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                'default' => [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'db'         => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'mysql:host=127.0.0.1;dbname=yinhao',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8mb4',

            // Schema cache options (for production environment)
            //'enableSchemaCache' => true,
            //'schemaCacheDuration' => 60,
            //'schemaCache' => 'cache',
        ],

        'mutex'       => [
            'class' => 'yii\mutex\FileMutex'
        ]

    ],
    'timeZone'   => 'Asia/Shanghai',
    // 'language'   => 'en-US',

    'params' => $params,
];

return $config;
