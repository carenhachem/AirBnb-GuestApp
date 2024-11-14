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
        Schema::create('accomodations', function (Blueprint $table) {
            $table->uuid('accomodationid')->primary();
            $table->string('description')->nullable();
            $table->double('pricepernight');
            $table->int('typeid');
            $table->json('amenityid');
            $table->int('guestcapacity');
            $table->json('policyid');
            $table->double('rating')->nullable();
            $table->json('image')->nullable();
            $table->boolean('isactive')->default(true);
            $table->timestamp('created')->default(now());
            $table->timestamp('updated')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accomodations');
    }
};
