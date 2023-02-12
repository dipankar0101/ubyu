<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_agents', function (Blueprint $table) {
            $table->bigIncrements('trip_agent_id');
            $table->string('trip_agent_name');
            $table->string('trip_agent_contact');
            $table->string('trip_agent_alternative_contact');
            $table->string('trip_agent_quote');
            $table->integer('trip_agent_expenses');
            $table->string('trip_agent_ratting');
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
        Schema::dropIfExists('trip_agents');
    }
}
