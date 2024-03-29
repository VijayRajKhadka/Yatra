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
        Schema::create('trek_image', function (Blueprint $table) {
            $table->id('trek_image_id');
            $table->string('trek_image_name');
            $table->string('trek_image_path');
            $table->unsignedBigInteger('trek_id');
            $table->foreign('trek_id')->references('trek_id')->on('trek');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trek_image');
    }
};
