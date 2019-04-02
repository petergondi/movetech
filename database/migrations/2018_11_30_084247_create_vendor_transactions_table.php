<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->nullable();
            $table->LongText('bussinessname')->nullable();
            $table->string('productid')->nullable();
            $table->LongText('productname')->nullable();
            $table->string('cost')->nullable();
            $table->string('paidamount')->nullable();
            $table->string('customername')->nullable();
            $table->string('phonenumber')->nullable();
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
        Schema::dropIfExists('vendor_transactions');
    }
}
