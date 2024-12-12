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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('transactionid')->primary()->default(DB::raw('uuid_generate_v4()'));
            $table->uuid('userid');
            $table->uuid('infoid');
            $table->decimal('amount', 10, 2); 
            $table->timestamp('paydate')->default(now());
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zipcode');
            $table->timestamps(); 

            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
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
