<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorsTable extends Migration
{
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->id('id_administrator');
            $table->unsignedBigInteger('id_employee');
            $table->foreign('id_employee')->references('id_employee')->on('employees');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('administrators');
    }
}
