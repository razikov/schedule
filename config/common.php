<?php

$config = [
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => require __DIR__ . '/../rbac/roles.php',
        ],
    ],
];

return $config;
