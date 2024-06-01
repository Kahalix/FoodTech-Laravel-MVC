<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicroorganismsTable extends Migration
{
    public function up()
    {
        Schema::create('microorganisms', function (Blueprint $table) {
            $table->id('id_microorganism');
            $table->string('name', 100);
            $table->string('type', 100);
            $table->string('safe_amount', 10, 2) ->nullable();
            $table->string('unit', 100) ->nullable();
            $table->string('safety', 100) ->nullable();
            $table->string('added_by', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('microorganisms');
    }
}
