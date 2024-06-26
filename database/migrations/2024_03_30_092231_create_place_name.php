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
        Schema::create('place', function (Blueprint $table) {
            $table->id('place_id');
            $table->string('name');
            $table->string('description');
            $table->string('location');
            $table->enum('category',["Park","Temple","Museum","Shopping-Mall","View-Point",'Other']);
            $table->string('open_time');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('get_there');
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
        Schema::dropIfExists('place');
    }
};
