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
        Schema::create('boats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fish_catch_id')->constrained('catches')->onDelete('cascade');
            $table->string('boat_name');
            $table->enum('boat_type', ['Motorized', 'Non-motorized']);
            $table->decimal('boat_length', 8, 2);
            $table->decimal('boat_width', 8, 2);
            $table->decimal('boat_depth', 8, 2);
            $table->decimal('gross_tonnage', 10, 2)->nullable();
            $table->integer('horsepower')->nullable();
            $table->string('engine_type')->nullable();
            $table->integer('fishermen_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boats');
    }
};
