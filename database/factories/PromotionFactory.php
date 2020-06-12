<?php

/** @var Factory $factory */

use App\Models\Promotion;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Promotion::class, function (Faker $faker) {
    return [
        'product_id' => null,
        'category_id' => null,
        'promotion_percent' => rand(10,50),
        'start_at' => $faker->dateTimeBetween('-1 year'),
        'end_at' => $faker->dateTimeBetween('now', '+1 year'),
    ];
});
