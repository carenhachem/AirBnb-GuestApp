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
        Schema::create('accomodationlocations', function (Blueprint $table) {
        $table->uuid('locationid')->primary();  
        $table->string('city');  
        $table->string('address');  
        $table->double('latitude');  
        $table->double('longitude'); 
        $table->timestamp('created')->default(now());
        $table->timestamp('updated')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accomodationlocations');
    }
};
