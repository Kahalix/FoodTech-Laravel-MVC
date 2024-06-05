<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('ingredients')->insert([
            [
                'name' => 'Ingredient A',
                'safe_amount' => '10.00',
                'unit' => 'grams',
                'safety' => 'Safe',
                'added_by' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ingredient B',
                'safe_amount' => '20.00',
                'unit' => 'grams',
                'safety' => 'Safe',
                'added_by' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
