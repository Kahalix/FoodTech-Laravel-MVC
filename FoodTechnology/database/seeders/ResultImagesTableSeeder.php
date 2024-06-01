<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResultImagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('result_images')->insert([
            [
                'id_test_result' => 1,
                'image_path' => 'result_images/default_image.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_test_result' => 2,
                'image_path' => 'result_images/default_image.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
