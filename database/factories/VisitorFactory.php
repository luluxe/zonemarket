<?php

/** @var Factory $factory */

use App\Models\Visitor;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Visitor::class, function (Faker $faker) {
    return [
        'total' => rand(10,50)
    ];
});
