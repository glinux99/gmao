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
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('demandeur_id')->nullable();
            $table->foreign('demandeur_id')->references('id')->on('users')->nullOnDelete();
            $table->string('reference_id')->nullable();
            $table->string('etat')->nullable();
            $table->string('type')->nullable()->default('entry');
            $table->boolean("is_remise")->default(false);
            $table->bigInteger('entry_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('entry_id')->references('id')->on('entries')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
            $table->double('quantity')->default(0)->nullable();
            $table->double('quantity_restante')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};
