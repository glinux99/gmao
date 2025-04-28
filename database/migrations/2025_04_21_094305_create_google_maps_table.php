<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('google_maps', function (Blueprint $table) {
            $table->id();
            $table->string('zone')->nullable();
            $table->string('code_rm')->nullable();
            $table->string('client_number')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('commercial_agent_name')->nullable();
            $table->string('connection_type')->nullable();
            $table->string('rate')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('installation_type')->nullable();
            $table->integer('days')->nullable();
            $table->date('payment_date')->nullable();
            $table->boolean('need_small_pole')->default(false)->nullable();
            $table->integer('pole')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_maps');
    }
};
