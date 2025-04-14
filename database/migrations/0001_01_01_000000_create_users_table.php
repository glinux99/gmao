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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('post_name')->nullable();
            $table->string('number')->nullable();
            $table->string('pointure')->nullable();
            $table->string('size')->nullable();
            $table->string('type')->nullable();
            $table->string('function')->nullable();
            $table->string('level')->nullable();
            $table->string('provider')->nullable();
            $table->string('status')->nullable();
            $table->text('address')->nullable();
            $table->text('category')->nullable();
            $table->text('token_email')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');
            $table->string('contrat')->nullable()->default('virunga');
            $table->string('avatar')->nullable()->default('/assets/media/avatars/defaut.png');
            $table->string('nickname')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default(bcrypt(12345678))->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
