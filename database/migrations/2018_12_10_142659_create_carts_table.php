<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->LongText('bussinessname')->nullable();
            $table->string('cartorder')->nullable();
            $table->string('productid')->nullable();
            $table->string('modelnumber')->nullable();
            $table->string('productname')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('pieces')->nullable();
            $table->string('costperpiece')->nullable();
            $table->string('totalcost')->nullable();
            $table->string('status')->nullable();
            $table->string('date')->nullable();
            $table->string('datetime')->nullable();
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
        Schema::dropIfExists('carts');
    }
}
