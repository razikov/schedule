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
    ],
];

return $config;
