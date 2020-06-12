<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\Promotion;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::query()->firstOrCreate([
            'email' => 'lucas.durand69230@gmail.com',
        ], [
            'name' => 'luluxe',
            'password' => bcrypt('cacaolol'),
        ]);

        if (User::query()->count() != 0) {
            return;
        }

        $this->users();
        $this->fixTransactions();
        $this->promotions();
    }

    /**
     * Add fake user with fake informations
     */
    public function users()
    {
        factory(User::class, 100)->create()->each(function ($user) {

            // With fake transactions
            $user->transactions()->saveMany(factory(Transaction::class, rand(1, 5))->create([
                'user_id' => $user->id,
            ]))->each(function ($transaction) {

                // With fake transaction product
                $transaction->products()->saveMany(factory(TransactionProduct::class, rand(1, 20))->create([
                    'transaction_id' => $transaction->id,
                ])->each(function ($product) {

                    // With fake product comment
                    if (rand(1, 5) == 1) {
                        factory(ProductComment::class)->create([
                            'product_id' => $product->product->id,
                            'user_id' => $product->transaction->user_id,
                        ]);
                    }
                }));
            });
        });
    }

    /**
     * Fix amount of transactions
     */
    public function fixTransactions()
    {
        foreach (Transaction::all() as $transaction) {
            $transaction->base_amount = 0;
            $transaction->amount = 0;

            foreach ($transaction->products as $product) {
                $transaction->base_amount += $product->base_amount * $product->quantity;
                $transaction->amount += $product->amount * $product->quantity;
            }

            $transaction->save();
        }
    }

    /**
     * Create fake promotions
     */
    public function promotions()
    {
        // Promotion for category
        foreach(Category::all() as $category) {
            if(rand(1, 7) == 1) {
                factory(Promotion::class)->create([
                    'category_id' => $category->id,
                ]);
            }
        }

        // Promotion for product
        foreach(Product::all() as $product) {
            if(rand(1, 6) == 1) {
                factory(Promotion::class)->create([
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
