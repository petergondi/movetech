<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMpesaStkRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_stk_requests', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->integer('phone'); 
             $table->integer('amount'); 
             $table->string('reference'); 
             $table->string('description'); 
             $table->string('CheckoutRequestID'); 
             $table->string('MerchantRequestID'); 
             $table->string('user_id');
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
        Schema::dropIfExists('table_mpesa_stk_requests');
    }
}
