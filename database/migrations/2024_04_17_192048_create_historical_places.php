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
        Schema::create('historical_places', function (Blueprint $table) {
            $table->id('historical_place_id');
            $table->string('name')->unique();
            $table->string('location');
            $table->string('description');
            $table->string('get_there');
            $table->string('map_url');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('open_time');
            $table->string('ticket_price');
            $table->string('contact_no');
            $table->boolean('isDeleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_places');
    }
};
