<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Prod Seeder
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);

        // Dev Seeder
        $this->call(DevSeeder::class);
    }
}
