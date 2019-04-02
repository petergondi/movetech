<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->nullable();
            $table->LongText('bussinessname')->nullable();
            $table->LongText('productname')->nullable();
            $table->LongText('category')->nullable();
            $table->LongText('subcategory')->nullable();
            $table->LongText('productfeatures')->nullable();
            $table->LongText('productdescription')->nullable();
            $table->string('imageurl')->nullable();
            $table->string('currentcost')->nullable();
            $table->string('previuscost')->nullable();
            $table->string('percentageoff')->nullable();
            $table->string('status')->nullable();
            $table->string('modelnumber')->nullable();
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
        Schema::dropIfExists('products');
    }
}
