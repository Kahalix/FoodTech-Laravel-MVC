<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductIngredientsTable extends Migration
{
    public function up()
    {
        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->id('id_product_ingredient');
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_ingredient')->nullable();
            $table->string('name', 100)->nullable();
            $table->decimal('ingredient_amount', 10, 2);
            $table->string('unit', 20);
            $table->string('completed_by', 50);

            $table->foreign('id_product')->references('id_product')->on('products');
            $table->foreign('id_ingredient')->references('id_ingredient')->on('ingredients');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_ingredients');
    }
}
