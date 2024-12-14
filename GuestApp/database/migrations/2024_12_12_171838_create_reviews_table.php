<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
                $table->uuid('reviewid')->primary()->default(DB::raw('gen_random_uuid()'));
                $table->uuid('accomodationid');
                $table->foreign('accomodationid')
                    ->references('accomodationid')
                    ->on('accomodations') 
                    ->onDelete('cascade');
                $table->uuid('userid');
                $table->foreign('userid')
                    ->references('userid')
                    ->on('users') 
                    ->onDelete('cascade');
                $table->double('rating')->nullable();
                $table->text('review')->nullable();
                $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
