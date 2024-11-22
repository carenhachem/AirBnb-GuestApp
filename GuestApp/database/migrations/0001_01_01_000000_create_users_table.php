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
        DB::statement('CREATE EXTENSION IF NOT EXISTS pgcrypto;'); // Enable pgcrypto extension

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('userid')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password')->nullable(); 
            $table->uuid('loginmethodid')->nullable();
            $table->foreign('loginmethodid')
              ->references('loginmethodid')
              ->on('logins') 
              ->onDelete('set null'); 
            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->default(now());
            $table->string('google_id')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
