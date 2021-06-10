<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'rd_app',
    'name' => 'RydoBid',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' => ['class' => '\kartik\grid\Module']
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'ghtCuOnnvd918hJPKk__-k-oXYgsuJRz',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
            'baseUrl' => 'https://rydobid.xyz/web/',
            'hostInfo' => 'https://rydobid.xyz/web/',
        ],
    /* 'assetManager' => [
      'bundles' => [
      'yii\web\JqueryAsset' => [
      'sourcePath' => null,
      'basePath' => '@webroot',
      'baseUrl' => '@web',
      'js' => [
      'js/jquery.js',
      ]
      ],
      ],
      ], */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', $_SERVER['REMOTE_ADDR']],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', $_SERVER['REMOTE_ADDR']],
    ];
}

return $config;
