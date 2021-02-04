<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CategoryTranslation;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(CategoryTranslation::class, function (Faker $faker){
    return [
        'name' => $faker->name,
    ];
});
