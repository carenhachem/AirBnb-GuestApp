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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('transactionid')->primary();
            $table->uuid('userid');
            $table->uuid('paymentmethodid');
            $table->uuid('infoid');
            $table->decimal('amount', 10, 2); 
            $table->timestamp('paydate')->default(now());

            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->foreign('paymentmethodid')->references('paymentid')->on('payments')->onDelete('cascade');
            $table->foreign('infoid')->references('cardinfoid')->on('cardinfos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
