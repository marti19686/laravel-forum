<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Chanel;
use Faker\Generator as Faker;

$factory->define(Chanel::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name
    ];
});

