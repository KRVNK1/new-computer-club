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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tariff_id')->constrained()->onDelete('cascade');
            $table->integer('hours')->nullable();
            // $table->dateTime('start_time');
            // $table->dateTime('end_time');
            $table->integer('people')->nullable();
            $table->string('comment');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
