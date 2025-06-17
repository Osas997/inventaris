<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'admin',
        ]);

        $category = Category::create([
            'name' => 'Baju'
        ]);

        Product::create([
            'name' => 'Baju Pria Hitam',
            'price' => 100000,
            'stock_quantity' => 10,
            'category_id' => $category->id
        ]);
    }
}
