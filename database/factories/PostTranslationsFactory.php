<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\PostTranslation::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'body' => $faker->text()
    ];
});
