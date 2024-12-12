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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->uuid('wishlistid')->primary();
            $table->uuid('userid');
            $table->foreign('userid')
                    ->references('userid')
                    ->on('users') 
                    ->onDelete('cascade');
            $table->uuid('accomodationid');
            $table->foreign('accomodationid')
                    ->references('accomodationid')
                    ->on('accomodations') 
                    ->onDelete('cascade');
            $table->timestamp('created')->default(now());
            $table->timestamp('updated')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
