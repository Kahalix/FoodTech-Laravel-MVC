<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecretariesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('secretaries')->insert([
            [
                'id_employee' => 2, // Assuming the Secretary1 user ID is 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_employee' => 3, // Assuming the Secretary2 user ID is 3
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
