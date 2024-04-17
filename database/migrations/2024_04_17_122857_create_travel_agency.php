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
        Schema::create('travel_agency', function (Blueprint $table) {
            $table->id('agency_id');
            $table->string('name');
            $table->string('email');
            $table->string('contact_no');
            $table->string('location');
            $table->string('document_url');
            $table->string('registration_no');
            $table->string('agency_image_url');
            $table->boolean('approve')->default(0);
            $table->unsignedBigInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_agency');
    }
};
