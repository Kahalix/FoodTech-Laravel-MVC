<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id('id_test_result');
            $table->unsignedBigInteger('id_product');
            $table->text('test_results');
            $table->string('decision', 100);
            $table->foreign('id_product')->references('id_product')->on('products');


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_results');
    }
}
