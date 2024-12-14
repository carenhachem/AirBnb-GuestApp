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
        Schema::create('cardinfos', function (Blueprint $table) {
            $table->uuid('cardinfoid')->primary()->default(DB::raw('uuid_generate_v4()'));
            $table->string('nameoncard');
            $table->string('creditcardnumber');
            $table->string('expmonth');
            $table->integer('expyear');
            $table->string('cvv');
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
