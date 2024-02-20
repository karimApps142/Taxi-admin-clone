<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('city_id')->nullable();
            $table->foreignId('vehicle_id')->nullable();
            $table->string('name');
            $table->string('preferred_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->enum('role', ['rider', 'driver', 'admin'])->default('rider');
            $table->enum('status', ['active', 'blocked'])->default('active');
            $table->enum('ride_status', ['available', 'onRide'])->default('available');
            $table->enum('profile_status', ['pending', 'progress', 'complete'])->default('pending');
            $table->enum('active_status', ['online', 'offline'])->default('online');
            $table->unsignedInteger('is_phone_verified')->default(0);
            $table->text('avatar')->nullable();
            $table->longText('description')->nullable();
            $table->text('push_token')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->date('dob')->nullable();
            $table->text('resident')->nullable();
            $table->string('street_address')->nullable();
            $table->string('car_company')->nullable();
            $table->string('slug')->nullable();
            $table->string('car_model')->nullable();
            $table->string('car_color')->nullable();
            $table->string('vehicle_nr')->nullable();
            $table->enum('provider',  ['google', 'facebook', 'apple', 'app', 'web', null])->nullable();
            $table->unsignedInteger('with_chair')->nullable()->default(0);
            $table->unsignedInteger('with_dog')->nullable()->default(0);
            $table->unsignedInteger('with_pets')->nullable()->default(0);
            $table->unsignedInteger('free_rides')->default(0);
            $table->rememberToken();
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
};
