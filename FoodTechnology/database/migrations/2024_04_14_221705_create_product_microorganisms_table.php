<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMicroorganismsTable extends Migration
{
    public function up()
    {
        Schema::create('product_microorganisms', function (Blueprint $table) {
            $table->id('id_product_microorganism');
            $table->string('name', 100);
            $table->string('type', 100);
            $table->string('amount', 10, 2);
            $table->string('unit', 100);
            $table->string('completed_by', 100);
            $table->unsignedBigInteger('id_microorganism')->nullable();
            $table->unsignedBigInteger('id_product');

            $table->foreign('id_product')->references('id_product')->on('products');

            $table->foreign('id_microorganism')->references('id_microorganism')->on('microorganisms');


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_microorganisms');
    }
}
