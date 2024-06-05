<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->insert([
            [
                'id_secretary' => 1,
                'id_manager' => 1,
                'id_company' => 1,
                'name' => 'Order A',
                'date' => now(),
                'description' => 'Description of Order A',
                'status' => 'in progress',
                'deadline' => now()->addWeeks(2),
                'cost' => '100.0 zł',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_secretary' => 2,
                'id_manager' => 2,
                'id_company' => 2,
                'name' => 'Order B',
                'date' => now(),
                'description' => 'Description of Order B',
                'status' => 'assigned',
                'deadline' => now()->addWeeks(2),
                'cost' => '150.00 zł',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
