<?php

/** @var Factory $factory */

use App\Vacancy;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Vacancy::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->realText(20),
        'slug' => Str::slug($name),
        'company' => $faker->company,
        'description' => $faker->realText(500),
    ];
});
