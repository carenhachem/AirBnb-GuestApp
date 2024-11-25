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
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('reservationid')->primary();
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
            $table->date('checkin');
            $table->date('checkout');
            $table->double('totalprice');
            $table->boolean('isreserved')->default(true);
            $table->timestamp('created')->default(now());
            $table->timestamp('updated')->default(now());
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
