<?php

/** @var Factory $factory */

use App\Models\ProductComment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ProductComment::class, function (Faker $faker) {
    return [
        'note' => rand(1,5),
        'message' => $faker->text(),
    ];
});
