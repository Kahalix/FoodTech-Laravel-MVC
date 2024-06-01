<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTechnologistsTable extends Migration
{
    public function up()
    {
        Schema::create('food_technologists', function (Blueprint $table) {
            $table->id('id_food_technologist');
            $table->unsignedBigInteger('id_employee');
            $table->unsignedBigInteger('id_manager')->nullable();
            $table->foreign('id_employee')->references('id_employee')->on('employees');
            $table->foreign('id_manager')->references('id_manager')->on('managers')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_technologists');
    }
}
