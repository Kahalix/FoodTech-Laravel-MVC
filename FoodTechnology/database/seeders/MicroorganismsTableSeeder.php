<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MicroorganismsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('microorganisms')->insert([
            [
                'name' => 'Bacillus subtilis',
                'type' => 'Bacteria',
                'safe_amount' => '100.00',
                'unit' => 'g',
                'safety' => 'Safe',
                'added_by' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Saccharomyces cerevisiae',
                'type' => 'Yeast',
                'safe_amount' => '50.00',
                'unit' => 'g',
                'safety' => 'Safe',
                'added_by' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Escherichia coli',
                'type' => 'Bacteria',
                'safe_amount' => '100.00',
                'unit' => 'g',
                'safety' => 'Safe',
                'added_by' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]


        ]);
    }
}
