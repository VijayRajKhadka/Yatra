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
        Schema::create('restaurant', function (Blueprint $table) {
            $table->id('restaurant_id');
            $table->string('name');
            $table->string('description');
            $table->string('location');
            $table->enum('category',["Local","Fancy"]);
            $table->enum('affordability',["Cheap","Budget-Friendly","Expensive"]);
            $table->string('open_time');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('get_there');
            $table->string('pan')->nullable();
            $table->boolean('approve')->default(0);
            $table->bigint('added_by');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant');
    }
};
