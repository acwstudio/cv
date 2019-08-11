<?php

return [

    'preset' => [
        'user' => [
            'prefix' => 'user-',
            'path' => 'images/users',
            'temp' => 'images/temp-files/users/',
            'dummy' => 'images/dummies/',
            'height' => 200,
            'width' => 200,
            'manipulation' => Spatie\Image\Manipulations::FIT_CROP,
        ],
        'post' => [
            'prefix' => 'post-',
            'path' => 'images/posts/',
            'temp' => 'images/temp-files/posts/',
            'dummy' => 'images/dummies/',
            'height' => 300,
            'width' => 730,
            'manipulation' => Spatie\Image\Manipulations::FIT_CROP,
        ],

    ]

];