<?php

/** @var Factory $factory */

use App\Models\Transaction;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'base_amount' => 0,
        'amount' => 0,
    ];
});
