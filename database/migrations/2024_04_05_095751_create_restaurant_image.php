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
        Schema::create('restaurant_image', function (Blueprint $table) {
            $table->id('restaurant_image_id');
            $table->string('restaurant_image_name');
            $table->string('restaurant_image_path');
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id')->references('restaurant_id')->on('restaurant');
            $table->timestamps();
        
        });
    }
    protected $table = 'restaurant_image';

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_image');
    }
};
