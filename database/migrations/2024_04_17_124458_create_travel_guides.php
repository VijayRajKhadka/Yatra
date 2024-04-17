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
        Schema::create('travel_guides', function (Blueprint $table) {
            $table->id('guide_id');
            $table->string('name');
            $table->string('contact')->unique();
            $table->string('profile_url');
            $table->string('experience');
            $table->unsignedBigInteger('agency_id');
            $table->foreign('agency_id')->references('agency_id')->on('travel_agency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_guides');
    }
};
