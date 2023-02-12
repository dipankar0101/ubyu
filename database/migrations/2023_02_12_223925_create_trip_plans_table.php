<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_plans', function (Blueprint $table) {
            $table->bigIncrements('trip_plans_id');
            $table->integer('location_id');
            $table->date('trip_date');
            $table->time('trip_time');
            $table->string('activity');
            $table->integer('mode_of_travel');
            $table->integer('travel_agent_id');
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
        Schema::dropIfExists('trip_plans');
    }
}
