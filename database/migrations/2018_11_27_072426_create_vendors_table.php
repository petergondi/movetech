<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->LongText('bussinessname')->nullable();
            $table->LongText('bussinessaliasname')->nullable();
            $table->LongText('bussinessaddress')->nullable();
            $table->LongText('physicaladdress')->nullable();
            $table->LongText('bankaccount')->nullable();
            $table->string('krapin')->nullable();
            $table->string('email')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('smstoken')->nullable();
            $table->string('emailtoken')->nullable();
            $table->string('password')->nullable();
            $table->string('encyrptedpssd')->nullable();
            $table->string('priority')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
