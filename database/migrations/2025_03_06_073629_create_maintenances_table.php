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
            $table->unsignedBigInteger('assigned_user_id')->nullable();
            $table->unsignedBigInteger('assigned_team_id')->nullable();
            $table->unsignedBigInteger('equipment_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('set null');
            $table->foreign('assigned_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assigned_team_id')->references('id')->on('teams')->onDelete('set null');

            $table->string('work_order')->nullable();
            $table->double('nbre_tacherons')->nullable()->default(0);
            $table->double('price_tacherons')->nullable()->default(0);
            $table->string('materiels')->nullable();
            $table->string('frequency')->nullable();
            $table->string('region')->nullable();
            $table->string('type')->nullable();

            // $table->a('techniciens')->nullable();
            $table->decimal('man_hours', 8, 2)->nullable(); // Example: 123456.78
            $table->decimal('maintenance_cost', 10, 2)->nullable(); // Example: 12345678.90
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
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
