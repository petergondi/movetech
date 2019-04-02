<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_tbs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date')->nullable();
            $table->string('datetime')->nullable();
            $table->string('fname')->nullable();
            $table->string('email')->nullable();
            $table->string('phonenumber')->nullable();
            $table->LongText('location')->nullable();
            $table->LongText('subject')->nullable();
            $table->LongText('question')->nullable();
            $table->LongText('replyquestion')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('question_tbs');
    }
}
