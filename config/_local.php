<?php

$config = [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=schedule',
            'username' => 'root',
            'password' => 'hexrf88',
            'charset' => 'utf8',
        ],
        'schedule_info' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=iro_info',
            'username' => 'root',
            'password' => 'hexrf88',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
    ],
];

return $config;
