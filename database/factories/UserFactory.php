<?php

/** @var Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $last_visit = $faker->dateTimeBetween('-1 year');
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt(Str::random()), // password
        'remember_token' => Str::random(10),
        'visited_at' => $last_visit,
        'credit_card' => rand(1000,9999),
        'deleted_at' => rand(0, 10) == 0 ? $faker->dateTimeBetween($last_visit) : null,
    ];
});
