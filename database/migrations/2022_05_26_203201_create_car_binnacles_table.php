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
        Schema::create('car_binnacles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id');
            $table->dateTime('delivery_time');
            $table->foreignId('deliver_by_user_id');
            $table->dateTime('departure_time')->nullable();
            $table->foreignId('departure_by_user_id')->nullable();
            $table->double('amount')->nullable();
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('cars');
            $table->foreign('deliver_by_user_id')->references('id')->on('users');
            $table->foreign('departure_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_binnacles');
    }
};
