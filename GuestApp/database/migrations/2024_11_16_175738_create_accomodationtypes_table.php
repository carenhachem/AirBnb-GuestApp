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
        Schema::create('accomodationtypes', function (Blueprint $table) {
            $table->uuid('typeid')->primary();
            $table->string('accomodationdesc');
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
        Schema::dropIfExists('accomodationtypes');
    }
};
