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
        Schema::create('refresh_tokens', function (Blueprint $table) {
        $table->uuid('refreshtokenid')->primary()->default(DB::raw('gen_random_uuid()'));
        $table->uuid('userid')->nullable();
        $table->foreign('userid')
            ->references('userid')
            ->on('users') 
            ->onDelete('cascade ');
        $table->string('refresh_token');
        $table->timestamp('expires_at');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refresh_tokens');
    }
};
