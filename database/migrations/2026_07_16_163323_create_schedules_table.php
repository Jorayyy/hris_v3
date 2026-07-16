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
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // e.g., "Regular Day Shift", "Night Shift"
        $table->time('shift_in');   // Expected Clock In (e.g., 08:00:00)
        $table->time('shift_out');  // Expected Clock Out (e.g., 17:00:00)
        $table->integer('grace_period')->default(15); // Grace period in minutes
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
