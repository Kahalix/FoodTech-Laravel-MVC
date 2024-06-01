<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id('id_company');
            $table->string('name', 100);
            $table->string('nip', 50);
            $table->string('address', 100);
            $table->string('postal_code', 50);
            $table->string('city', 50);
            $table->string('phone_number', 20);
            $table->string('email', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
