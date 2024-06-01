<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductMicroorganismsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_microorganisms')->insert([
            [
                'name' => 'Product A Microorganism',
                'type' => 'Bacteria',
                'amount' => '25.00',
                'unit' => 'g',
                'completed_by' => 'FoodTechnologist',
                'id_microorganism' => 1,
                'id_product' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product B Microorganism',
                'type' => 'Yeast',
                'amount' => '30.00',
                'unit' => 'g',
                'completed_by' => 'FoodTechnologist',
                'id_microorganism' => 2,
                'id_product' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
