<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CalenderAvailability extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_availability', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('reocuuring', ['0','1','2'])->comment('0=>Monday to Friday,1=>Monday to Saturday,2=>Daily');
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
        Schema::drop('calendar_availability');
    }
}
