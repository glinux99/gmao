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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->string('caracteristique')->nullable();
            $table->string('description')->nullable();
            $table->string('avatar')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('unity_id')->nullable()->unsigned();
            $table->foreign('unity_id')->references('id')->on('unities')->cascadeOnUpdate()->nullOnDelete();
            $table->boolean('is_remise')->default(true)->nullable();
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
