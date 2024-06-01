<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('id_employee');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('employee_image', 100);
            $table->string('position', 50);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number', 20);
            $table->string('login', 50);
            $table->string('password', 100);
            $table->string('status', 50)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
