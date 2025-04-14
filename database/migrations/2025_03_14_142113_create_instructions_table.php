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
        Schema::create('instructions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('task_id')->nullable(); // Foreign key linking to the task
            $table->text('description'); // The instruction text
            $table->text('value')->nullable(); // The instruction text
            $table->enum('response_type', ['checkbox', 'text / valeur', 'number','text']); // Type of response
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructions');
    }
};
