<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('trip_id');
            $table->integer('trip_author_id');
            $table->string('trip_name');
            $table->string('trip_start');
            $table->string('trip_end');
            $table->string('trip_type_by_people')->default('solo');
            $table->string('trip_status')->default('draft');
            $table->text('mood_tags')->nullable();
            $table->integer('accompanied_by_pet')->default('0');
            $table->integer('special_care_needed')->default('0');
            $table->integer('is_active')->default('0');
            $table->integer('is_delete')->default('0');
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
        Schema::dropIfExists('trips');
    }
}
