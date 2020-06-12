<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::query()->firstOrCreate(['name' => 'Prévention Covid-19']);
        Category::query()->firstOrCreate(['name' => 'Bio et Ecologie']);
        Category::query()->firstOrCreate(['name' => 'Fruits et Légumes']);
        Category::query()->firstOrCreate(['name' => 'Viandes et Poissons']);
        Category::query()->firstOrCreate(['name' => 'Pain et Patisseries']);
        Category::query()->firstOrCreate(['name' => 'Crémerie']);
        Category::query()->firstOrCreate(['name' => 'Fromage et Charcuterie']);
        Category::query()->firstOrCreate(['name' => 'Traiteur']);
        Category::query()->firstOrCreate(['name' => 'Surgelés']);
        Category::query()->firstOrCreate(['name' => 'Epicerie Salée']);
        Category::query()->firstOrCreate(['name' => 'Boissons sans alcool']);
        Category::query()->firstOrCreate(['name' => 'Alcools et Produits apérétif']);
        Category::query()->firstOrCreate(['name' => 'Hygiène et Beauté']);
        Category::query()->firstOrCreate(['name' => 'Le Monde de Bébé']);
        Category::query()->firstOrCreate(['name' => 'Animaux']);
    }
}
