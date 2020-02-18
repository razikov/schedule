<?php
return [
    'user-list' => [
        'type' => 2,
    ],
    'user-create' => [
        'type' => 2,
    ],
    'user-update' => [
        'type' => 2,
    ],
    'schedule-courses-list' => [
        'type' => 2,
    ],
    'schedule-themes-list' => [
        'type' => 2,
    ],
    'schedule-classroom-map' => [
        'type' => 2,
    ],
    'schedule-reservation-view' => [
        'type' => 2,
    ],
    'schedule-reservation-create' => [
        'type' => 2,
    ],
    'schedule-reservation-update' => [
        'type' => 2,
    ],
    'schedule-reservation-delete' => [
        'type' => 2,
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'RoleRule',
        'children' => [
            'user-create',
            'user-update',
            'user-list',
            'schedule-courses-list',
            'schedule-themes-list',
            'schedule-classroom-map',
            'schedule-reservation-view',
            'schedule-reservation-create',
            'schedule-reservation-update',
            'schedule-reservation-delete',
        ],
    ],
    'admin-schedule' => [
        'type' => 1,
        'ruleName' => 'RoleRule',
        'children' => [
            'schedule-courses-list',
            'schedule-themes-list',
            'schedule-classroom-map',
            'schedule-reservation-view',
            'schedule-reservation-create',
            'schedule-reservation-update',
            'schedule-reservation-delete',
        ],
    ],
    'user-schedule' => [
        'type' => 1,
        'ruleName' => 'RoleRule',
        'children' => [
            'schedule-courses-list',
            'schedule-themes-list',
            'schedule-classroom-map',
            'schedule-reservation-view',
        ],
    ],
];
