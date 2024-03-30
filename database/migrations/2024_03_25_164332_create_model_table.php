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
        Schema::create('trek', function (Blueprint $table) {
            $table->id('trek_id');
            $table->string('name');
            $table->string('description');
            $table->string('location');
            $table->enum('category',["Hiking","Short-Trek","Long-Trek","High-Altitude-Trek","Wild-Trek"]);
            $table->string('altitude');
            $table->enum('difficulty',["Easy","Intermediate","Hard","Extreme"]);
            $table->string('no_of_days');
            $table->string('emergency_no')->nullable();
            $table->string('map_url')->nullable();
            $table->enum('budgetRange',["1,000-5,000","5,000-10,000","10,0000-15,0000",
            "15,000-20,0000","20,0000-30,000", "30,000-40,0000","40,0000-50,0000","50,000+"]);
            $table->boolean('approve')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Trek');
    }
};
