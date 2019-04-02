<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host','120')->nullable();
            $table->string('port','10')->nullable();
            $table->string('username','120')->nullable();
            $table->string('password','120')->nullable();
            $table->string('fromaddress','120')->nullable();
            $table->string('fromname','120')->nullable();
            $table->string('subject','120')->nullable();
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
        Schema::dropIfExists('mail_settings');
    }
}
