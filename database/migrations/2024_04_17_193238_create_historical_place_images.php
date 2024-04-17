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
        Schema::create('historical_place_images', function (Blueprint $table) {
            $table->id('historical_place_images');
            $table->string('historical_place_image_name');
            $table->string('historical_place_image_path');
            $table->unsignedBigInteger('historical_place_id');
            $table->foreign('historical_place_id')->references('historical_place_id')->on('historical_places');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_place_images');
    }
};
