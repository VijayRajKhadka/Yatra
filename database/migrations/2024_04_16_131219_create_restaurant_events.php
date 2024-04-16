<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restaurant_events', function (Blueprint $table) {
            $table->id('event_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->string('name');
            $table->string('open_time');
            $table->string('location');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('title');
            $table->string('body');
            $table->string('event_image_path');
            $table->foreign('restaurant_id')->references('restaurant_id')->on('restaurant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_events');
    }
};
