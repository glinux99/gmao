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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name or model of the equipment (e.g., "Laptop HP ProBook", "Projector Epson")
            $table->string('serial_number')->unique()->nullable(); // Unique identifier for the equipment
            $table->string('status')->default('available')->nullable(); // e.g., "available", "in_use", "under_maintenance", "broken"
            $table->text('description')->nullable(); // Optional description of the equipment
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null'); // If equipment can be assigned to a project
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // If equipment can be assigned to a user
            $table->date('purchase_date')->nullable(); // When the equipment was purchased
            $table->decimal('purchase_price', 10, 2)->nullable(); // How much it cost
            $table->date('warranty_end_date')->nullable(); // When the warranty expires
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
