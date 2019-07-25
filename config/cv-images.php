<?php

return [

    'preset' => [
        'user' => [
            'prefix' => 'user-',
            'path' => 'images/users/',
            'temp' => 'images/temp-files/users/',
            'dummy' => 'images/dummies/',
            'height' => 230,
            'width' => 0,
            'manipulation' => Spatie\Image\Manipulations::FIT_CONTAIN,
        ],
        'post' => [
            'prefix' => 'post-',
            'path' => 'images/posts/',
            'temp' => 'images/temp-files/posts/',
            'dummy' => 'images/dummies/',
            'height' => 500,
            'width' => 0,
            'manipulation' => Spatie\Image\Manipulations::FIT_CONTAIN,
        ],

    ]

];