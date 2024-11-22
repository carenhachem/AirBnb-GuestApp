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
        Schema::create('usertokens', function (Blueprint $table) {
            $table->uuid('usertokenid')->primary();
            $table->string('token')->nullable(); ;
            $table->string('refreshtoken')->nullable();
            $table->uuid('userid'); 
            $table->foreign('userid')
              ->references('userid')
              ->on('users') 
              ->onDelete('cascade');
            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usertokens');
    }
};
