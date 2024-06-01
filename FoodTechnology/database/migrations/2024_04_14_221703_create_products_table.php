<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_product');
            $table->unsignedBigInteger('id_order');
            $table->unsignedBigInteger('id_food_technologist')->nullable();
            $table->string('name', 100);
            $table->string('status', 100);
            $table->string('product_image', 100);
            $table->foreign('id_order')->references('id_order')->on('orders');
            $table->foreign('id_food_technologist')->references('id_food_technologist')->on('food_technologists')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
