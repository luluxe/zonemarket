<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::query()->firstOrCreate(['category_id' => 1, 'name' => 'Gel hydro-alcoolique', 'price' => 5.25]);
        Product::query()->firstOrCreate(['category_id' => 1, 'name' => 'Lot de Masque', 'price' => 1.25]);
        Product::query()->firstOrCreate(['category_id' => 2, 'name' => 'Pain bio', 'price' => 6.23]);
        Product::query()->firstOrCreate(['category_id' => 2, 'name' => 'Belvita bio', 'price' => 5.23]);
        Product::query()->firstOrCreate(['category_id' => 3, 'name' => 'Bananes', 'price' => 2.54]);
        Product::query()->firstOrCreate(['category_id' => 3, 'name' => 'Pommes', 'price' => 2.6]);
        Product::query()->firstOrCreate(['category_id' => 4, 'name' => 'Filet de poulet', 'price' => 6.9]);
        Product::query()->firstOrCreate(['category_id' => 4, 'name' => 'Steak haché', 'price' => 4.56]);
        Product::query()->firstOrCreate(['category_id' => 5, 'name' => 'Pain', 'price' => 0.98]);
        Product::query()->firstOrCreate(['category_id' => 5, 'name' => 'Nougatine', 'price' => 6.85]);
        Product::query()->firstOrCreate(['category_id' => 6, 'name' => 'Fromage de chèvre', 'price' => 2.96]);
        Product::query()->firstOrCreate(['category_id' => 6, 'name' => 'Chaussé et au moine', 'price' => 3.15]);
        Product::query()->firstOrCreate(['category_id' => 7, 'name' => 'Saucisson', 'price' => 2.25]);
        Product::query()->firstOrCreate(['category_id' => 7, 'name' => 'Rilette de canard', 'price' => 4.95]);
        Product::query()->firstOrCreate(['category_id' => 8, 'name' => 'Pizza 4 Fromages', 'price' => 3.65]);
        Product::query()->firstOrCreate(['category_id' => 8, 'name' => 'Quiche', 'price' => 2.45]);
        Product::query()->firstOrCreate(['category_id' => 9, 'name' => 'Pizza reine', 'price' => 3.75]);
        Product::query()->firstOrCreate(['category_id' => 9, 'name' => 'Frite au four', 'price' => 4.89]);
        Product::query()->firstOrCreate(['category_id' => 10, 'name' => 'Chips barbecue', 'price' => 2.45]);
        Product::query()->firstOrCreate(['category_id' => 10, 'name' => 'Cacahuètes', 'price' => 1.55]);
        Product::query()->firstOrCreate(['category_id' => 11, 'name' => 'Ice Tea', 'price' => 1.89]);
        Product::query()->firstOrCreate(['category_id' => 11, 'name' => 'Coca Cola', 'price' => 2.45]);
        Product::query()->firstOrCreate(['category_id' => 12, 'name' => 'Get 31', 'price' => 19.85]);
        Product::query()->firstOrCreate(['category_id' => 12, 'name' => 'Vin blanc', 'price' => 8.95]);
        Product::query()->firstOrCreate(['category_id' => 13, 'name' => 'Shampoing aux huiles essentiels', 'price' => 2.65]);
        Product::query()->firstOrCreate(['category_id' => 13, 'name' => 'Febreze', 'price' => 3.85]);
        Product::query()->firstOrCreate(['category_id' => 14, 'name' => 'Couches', 'price' => 6.87]);
        Product::query()->firstOrCreate(['category_id' => 14, 'name' => 'Lait maternel', 'price' => 4.89]);
        Product::query()->firstOrCreate(['category_id' => 15, 'name' => 'Croquettes pour chien', 'price' => 8.95]);
        Product::query()->firstOrCreate(['category_id' => 15, 'name' => 'Croquettes pour chat', 'price' => 12.98]);
    }
}
