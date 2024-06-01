<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodTechnologistsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('food_technologists')->insert([
            [
                'id_employee' => 6, // Assuming the FoodTech1 user ID is 6
                'id_manager' => 1, // Assuming the Manager1 ID is 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_employee' => 7, // Assuming the FoodTech2 user ID is 7
                'id_manager' => 1, // Assuming the Manager1 ID is 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_employee' => 8, // Assuming the FoodTech3 user ID is 8
                'id_manager' => null, // Assuming no manager for FoodTech3
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_employee' => 9, // Assuming the FoodTech4 user ID is 9
                'id_manager' => null, // Assuming no manager for FoodTech4
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_employee' => 10, // Assuming the FoodTech5 user ID is 10
                'id_manager' => null, // Assuming no manager for FoodTech5
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
