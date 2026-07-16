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
    Schema::create('time_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('date');
        
        // Detailed shift tracking segments
        $table->time('clock_in')->nullable();
        $table->time('break1_out')->nullable();
        $table->time('break1_in')->nullable();
        $table->time('lunch_out')->nullable();
        $table->time('lunch_in')->nullable();
        $table->time('break2_out')->nullable();
        $table->time('break2_in')->nullable();
        $table->time('clock_out')->nullable();
        
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_logs');
    }
};
