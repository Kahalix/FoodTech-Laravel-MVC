<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManagersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('managers')->insert([
            [
                'id_employee' => 4, // Assuming the Manager1 user ID is 4
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_employee' => 5, // Assuming the Manager2 user ID is 5
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
