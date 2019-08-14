<?php

return [
    'permissions' => [
        'view_users',
        'add_users',
        'edit_users',
        'delete_users',
        'view_roles',
        'add_roles',
        'edit_roles',
        'delete_roles',
        'view_posts',
        'add_posts',
        'edit_posts',
        'delete_posts',
    ],
    'roles' => [
        'admin',
        'moderator',
        'writer',
        'user',
    ],

    'admin_password' => env('ADMIN_PASSWORD'),
];