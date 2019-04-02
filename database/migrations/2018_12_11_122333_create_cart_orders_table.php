<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->LongText('customername')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('email')->nullable();
            $table->LongText('location')->nullable();
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
        Schema::dropIfExists('cart_orders');
    }
}
