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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('caracteristique')->nullable();
            $table->string('etat')->nullable()->default("bon");
            $table->text('description')->nullable();
            $table->double('quantity')->nullable();
            $table->double('quantity_restante')->nullable();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('stockhistory_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('stockhistory_id')->references('id')->on('stock_histories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
