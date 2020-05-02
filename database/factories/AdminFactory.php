<?php

/** @var Factory $factory */

use App\Admin;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => 'admin@test.com',
        'password' => bcrypt('admin@test.com'), // password
        'remember_token' => Str::random(10),
    ];
});
