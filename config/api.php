<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/' . MAIN_HOST . '.db.php';

$config = [
    'id' => 'basic',
    'viewPath' => dirname(__DIR__) . '/views_api',
    'name' => 'Чернолист',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\\controllers_api',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            //'enableCsrfValidation' => isset($_REQUEST['secret_scrf']) && md5($_REQUEST['secret_scrf']) === '45db0cb82d0dc8d967c0ef23232bf9f3' ? false : true,
            'cookieValidationKey' => 'YqXHItRP6Js4lDSUNkafeB8Anjmfq_nE',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usr',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => false,
                'yii\bootstrap\BootstrapPluginAsset' => false,
                'yii\bootstrap\BootstrapAsset' => false,
            ],
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
            'showScriptName' => true,
            'enableStrictParsing' => true,
            'rules' => [
                //'<controller:\w+>/<action:[\w\-]+>' => '<controller>/<action>',
                'GET <controller:\w+>' => '<controller>/index',
                'GET <controller:\w+>/<action:[\w\-]+>' => '<controller>/<action>-index',
                'PUT <controller:\w+>' => '<controller>/add',
                'POST <controller:\w+>' => '<controller>/add',
                'PUT <controller:\w+>/<action:[\w\-]+>' => '<controller>/<action>-add',
                'POST <controller:\w+>/<action:[\w\-]+>' => '<controller>/<action>-add',
                // [
                //     // правиля для модуля admin
                //     'class' => 'yii\web\GroupUrlRule',
                //     'prefix' => 'api',
                //     'routePrefix' => 'api',
                //     'rules' => [
                //         '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
                //     ],
                // ],
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        //        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
