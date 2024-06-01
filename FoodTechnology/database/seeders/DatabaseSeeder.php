<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EmployeesTableSeeder::class,
            ManagersTableSeeder::class,
            AdministratorsTableSeeder::class,
            SecretariesTableSeeder::class,
            FoodTechnologistsTableSeeder::class,
            CompaniesTableSeeder::class,
            OrdersTableSeeder::class,
            ProductsTableSeeder::class,
            MicroorganismsTableSeeder::class,
            ProductMicroorganismsTableSeeder::class,
            IngredientsTableSeeder::class,
            ProductIngredientsTableSeeder::class,
            TestResultsTableSeeder::class,
            ResultImagesTableSeeder::class,

        ]);
    }
}
