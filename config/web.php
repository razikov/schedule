<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'schedule',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'SX91nJePfKE1e1oX-5mCTZue_78cADop',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'arrayCache' => [
            'class' => \yii\caching\ArrayCache::class,
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
        'db' => require(__DIR__ . '/db.php'),
        
        'schedule_info' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=schedule_info',
            'username' => 'root',
            'password' => 'hexrf88',
            'charset' => 'utf8',
        ],
        
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm',
            'nullDisplay' => '',
            'currencyCode' => 'RUB',
            'defaultTimeZone' => 'Europe/Moscow',
            'timeZone' => 'Europe/Moscow',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                "<controller>/<action>" => "<controller>/<action>",
                "<module>/<controller>/<action>" => "<module>/<controller>/<action>",
            ],
        ],
        
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => app\models\User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['/site/login'],
        ],
        
        'defaultRoute' => 'schedule-info/presentation',
    ],
    'modules' => [
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset'
    ],
    'params' => $params,
    'language' => 'ru-RU',
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
}

return $config;
