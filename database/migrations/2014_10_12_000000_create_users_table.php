<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('role_id')->default('3')->comment('Super Admin=1, Trip Admin=2, Normal User = 3');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->integer('email_verified')->default('0');
            $table->integer('phone_verified')->default('0');
            $table->integer('otp_check')->nullable();
            $table->string('profile_image')->nullable();
            $table->integer('status')->default('1');
            $table->string('device_id')->nullable();
            $table->string('os_type')->nullable();
            $table->string('social_id')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('users');
    }
}
