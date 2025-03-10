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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id')->nullable();
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('set null');
            $table->string('work_order')->nullable();
            $table->decimal('man_hours', 8, 2)->nullable(); // Example: 123456.78
            $table->decimal('maintenance_cost', 10, 2)->nullable(); // Example: 12345678.90
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('pending'); // e.g., pending, in_progress, completed
            $table->unsignedBigInteger('user_id')->nullable(); // Add technician_id
             $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Foreign key to technicians table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
