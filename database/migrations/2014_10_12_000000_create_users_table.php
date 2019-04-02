<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendorname')->nullable();
            $table->LongText('fname')->nullable();
            $table->string('name')->nullable();
            $table->LongText('location')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('address')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->string('smstoken')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->string('idno')->nullable();
            $table->string('cap')->nullable();
            $table->string('balance')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
