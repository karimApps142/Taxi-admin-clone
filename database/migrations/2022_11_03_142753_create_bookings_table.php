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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_nr')->nullable();
            $table->foreignId('rider_id');
            $table->foreignId('driver_id')->nullable();
            $table->foreignId('vehicle_id')->nullable();
            $table->longText('reject_ids')->nullable();
            $table->longText('accept_ids')->nullable();
            $table->longText('pending_ids')->nullable();
            $table->decimal('pickup_lat', 10, 7)->nullable();
            $table->decimal('pickup_lng', 10, 7)->nullable();
            $table->text('pickup_address')->nullable();
            $table->string('pickup_region')->nullable();
            $table->text('pickup_placeId')->nullable();
            $table->decimal('dropoff_lat', 10, 7)->nullable();
            $table->decimal('dropoff_lng', 10, 7)->nullable();
            $table->text('dropoff_address')->nullable();
            $table->string('dropoff_region')->nullable();
            $table->text('dropoff_placeId')->nullable();
            $table->string('area')->nullable();
            $table->longText('details')->nullable();
            $table->unsignedBigInteger('radius')->nullable();
            $table->string('currency')->default('usd');
            $table->string('vehicle')->nullable();
            $table->longText('cancelled_text')->nullable();
            $table->enum('payment_type', ['cash', 'card'])->default('cash');
            $table->enum('booking_type', ['instant', 'future'])->default('instant');
            $table->enum('cancelled_by', [null, 'driver', 'rider'])->nullable();
            $table->unsignedInteger('with_chair')->default(0);
            $table->unsignedInteger('with_dog')->default(0);
            $table->unsignedInteger('with_pets')->default(0);
            $table->timestamp('date')->nullable();
            $table->timestamp('time')->nullable();
            $table->enum('status', [
                'pending',
                'accepted',
                'enRoute',
                'arrived',
                'progress',
                'completed',
                'cancelled',
                'expired',
            ])->default('pending');
            $table->decimal('price', 9, 2)->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
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
        Schema::dropIfExists('bookings');
    }
};
