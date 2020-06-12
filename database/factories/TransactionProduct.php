<?php

/** @var Factory $factory */

use App\Models\Product;
use App\Models\TransactionProduct;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(TransactionProduct::class, function (Faker $faker) {
    $product = Product::all()->random();
    return [
        'product_id' => $product->id,
        'quantity' => rand(1,3),
        'base_amount' => $product->price,
        'amount' => rand(1,3) == 1 ? round($product->price * $faker->randomFloat(2, 0.5, 0.98), 2) : $product->price,
    ];
});
