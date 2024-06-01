<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'id_order' => 1,
                'id_food_technologist' => 1,
                'name' => 'Product A',
                'status' => 'assigned',
                'product_image' => 'product_images/default_image.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_order' => 2,
                'id_food_technologist' => 2,
                'name' => 'Product B',
                'status' => 'assigned',
                'product_image' => 'product_images/default_image.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_order' => 2,
                'id_food_technologist' => null,
                'name' => 'Product C',
                'status' => 'pending',
                'product_image' => 'product_images/default_image.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_order' => 2,
                'id_food_technologist' => null,
                'name' => 'Product D',
                'status' => 'pending',
                'product_image' => 'product_images/default_image.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_order' => 1,
                'id_food_technologist' => null,
                'name' => 'Product E',
                'status' => 'pending',
                'product_image' => 'product_images/default_image.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
