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
    Schema::create('payrolls', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('pay_period'); // e.g., "July 2026"
        $table->decimal('base_salary', 10, 2);
        $table->decimal('bonus', 10, 2)->default(0.00);
        $table->decimal('deductions', 10, 2)->default(0.00);
        $table->decimal('net_pay', 10, 2);
        $table->string('status')->default('Unpaid'); // Unpaid, Paid
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
