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
        Schema::create('accomodationpolicies', function (Blueprint $table) {
            $table->uuid('accomodationpolicyid');

            $table->uuid('accomodationid');
            $table->foreign('accomodationid')
            ->references('accomodationid')
            ->on('accomodations')
            ->onDelete('cascade');

            $table->uuid('policyid');
            $table->foreign('policyid')
            ->references('policyid')
            ->on('policies')
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
        Schema::dropIfExists('accomodationpolicies');
    }
};
