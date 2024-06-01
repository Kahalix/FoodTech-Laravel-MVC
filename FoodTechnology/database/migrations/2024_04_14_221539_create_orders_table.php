<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->unsignedBigInteger('id_secretary')->nullable();
            $table->unsignedBigInteger('id_manager')->nullable();
            $table->unsignedBigInteger('id_company')->nullable();
            $table->string('name', 100);
            $table->date('date')->default(now());
            $table->text('description');
            $table->string('status', 50)->default('assigned');
            $table->date('deadline')->default(now()->addWeeks(2));
            $table->string('cost', 100);

            $table->foreign('id_secretary')->references('id_secretary')->on('secretaries');
            $table->foreign('id_manager')->references('id_manager')->on('managers')->onDelete('SET NULL');
             $table->foreign('id_company')->references('id_company')->on('companies');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
