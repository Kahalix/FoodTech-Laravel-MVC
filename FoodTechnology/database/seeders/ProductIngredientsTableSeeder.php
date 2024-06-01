<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductIngredientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_ingredients')->insert([
            [
                'id_product' => 1, // Assuming the Product A ID is 1
                'id_ingredient' => 1, // Assuming the Ingredient A ID is 1
                'name' => 'Ingredient A',
                'ingredient_amount' => '5.00',
                'unit' => 'grams',
                'completed_by' => 'FoodTechnologist',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_product' => 1, // Assuming the Product A ID is 1
                'id_ingredient' => 2, // Assuming the Ingredient A ID is 1
                'name' => 'Ingredient B',
                'ingredient_amount' => '5.00',
                'unit' => 'grams',
                'completed_by' => 'FoodTechnologist',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_product' => 1, // Assuming the Product A ID is 1
                'id_ingredient' => null, // Assuming the Ingredient A ID is 1
                'name' => 'Ingredient C',
                'ingredient_amount' => '15.00',
                'unit' => 'grams',
                'completed_by' => 'company',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_product' => 2, // Assuming the Product B ID is 2
                'id_ingredient' => 2, // Assuming the Ingredient B ID is 2
                'name' => 'Ingredient B',
                'ingredient_amount' => '10.00',
                'unit' => 'grams',
                'completed_by' => 'FoodTechnologist',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more product-ingredient relationships as needed
        ]);
    }
}
