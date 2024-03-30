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
        Schema::create('place_image', function (Blueprint $table) {
            $table->id('place_image_id');
            $table->string('place_image_name');
            $table->string('place_image_path');
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')->references('place_id')->on('place');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_image');
    }
};
