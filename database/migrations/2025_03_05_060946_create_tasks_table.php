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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->string('status')->nullable();
            $table->string('comments')->nullable();
            $table->integer('complete')->nullable();
            $table->string('description')->nullable();
            $table->string('delay')->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('maintenance_id')->nullable()->constrained('maintenances')->onDelete('cascade');
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('priority_id')->nullable()->constrained('priorities')->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            // $table->foreignId('category_id')->nullable()->constrained('task_categories')->onDelete('cascade');
            $table->foreignId('owner')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('task_id')->nullable()->constrained('tasks')->nullOnDelete();
            $table->string('assigned_date')->nullable();
            $table->string('start_date')->nullable();
            $table->string('start_date_user')->nullable();
            $table->string('due_date')->nullable();
            $table->string('due_date_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
