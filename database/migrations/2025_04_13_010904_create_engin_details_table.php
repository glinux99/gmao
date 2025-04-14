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
        Schema::create('engin_details', function (Blueprint $table) {
            $table->id();
            $table->string('chauffeur')->nullable();
            $table->foreignId('engin_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('kilometrage_debut')->nullable();
            $table->string('kilometrage_fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engin_details');
    }
};
