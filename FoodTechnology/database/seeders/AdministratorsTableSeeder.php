<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministratorsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('administrators')->insert([
            [
                'id_employee' => 1, // Assuming the admin user ID is 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
