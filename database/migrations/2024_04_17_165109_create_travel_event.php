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
        Schema::create('travel_events', function (Blueprint $table) {
            $table->id('event_id');
            $table->unsignedBigInteger('agency_id');
            $table->string('name');
            $table->string('contact_no');
            $table->string('email');
            $table->string('location');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('title');
            $table->string('body');
            $table->string('event_image_path');
            $table->foreign('agency_id')->references('agency_id')->on('travel_agency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_event');
    }
};
