<?php

$config = [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=schedule_test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'schedule_info' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=schedule_info',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'localhost',
                'username' => 'username',
                'password' => 'password',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
];

return $config;
