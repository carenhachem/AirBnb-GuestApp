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
        Schema::create('cardinfos', function (Blueprint $table) {
            $table->uuid('cardinfoid')->primary();
            $table->string('cardholdername');
            $table->string('cardnumber');
            $table->date('expirationdate');
            $table->string('cvv'); 
            $table->string('email');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cardinfos');
    }
};
