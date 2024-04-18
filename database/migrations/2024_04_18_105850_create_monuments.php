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
        Schema::create('monuments', function (Blueprint $table) {
            $table->id('monuments_id');
            $table->string('name')->unique();
            $table->text('description');
            $table->string('monument_imageUrl');
            $table->unsignedBigInteger('historical_place_id');
            $table->foreign('historical_place_id')->references('historical_place_id')->on('historical_places')->cascade();
            $table->boolean('isDeleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monuments');
    }
};
