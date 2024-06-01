<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultImagesTable extends Migration
{
    public function up()
    {
        Schema::create('result_images', function (Blueprint $table) {
            $table->id('id_result_image');
            $table->unsignedBigInteger('id_test_result');
            $table->string('image_path', 100);
            $table->timestamps();
            $table->foreign('id_test_result')->references('id_test_result')->on('test_results')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('result_images');
    }
}

