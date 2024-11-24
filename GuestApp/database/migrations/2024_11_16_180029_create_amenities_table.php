<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('amenities', function (Blueprint $table) {
        $table->uuid('amenityid')->primary();
        $table->string('amenitydesc', 255);
        $table->boolean('isactive')->default(true);
        $table->timestamps(); // This creates 'created_at' and 'updated_at' columns
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};
