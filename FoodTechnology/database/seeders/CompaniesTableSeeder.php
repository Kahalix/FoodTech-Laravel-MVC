<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('companies')->insert([
            [
                'name' => 'Company A',
                'nip' => '1234567890',
                'address' => '123 Main St',
                'postal_code' => '12345',
                'city' => 'City A',
                'phone_number' => '1234567890',
                'email' => 'companya@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Company B',
                'nip' => '0987654321',
                'address' => '456 Elm St',
                'postal_code' => '54321',
                'city' => 'City B',
                'phone_number' => '0987654321',
                'email' => 'companyb@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more companies as needed
        ]);
    }
}
