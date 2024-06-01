<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestResultsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('test_results')->insert([
            [
                'id_product' => 1,
                'test_results' => 'Test results for Product A',
                'decision' => 'Approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_product' => 2,
                'test_results' => 'Test results for Product B',
                'decision' => 'Rejected',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
