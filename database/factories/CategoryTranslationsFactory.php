<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

//$locales = ['en', 'ru'];

$factory->define(\App\CategoryTranslation::class, function (Faker $faker){
    return [
        'locale' => 'en',
        'name' => $faker->name,
    ];
});
