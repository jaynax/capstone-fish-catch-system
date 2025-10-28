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
        Schema::create('fishing_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fish_catch_id')->constrained('catches')->onDelete('cascade');
            $table->string('fishing_gear_type');
            $table->text('gear_specifications')->nullable();
            $table->integer('hooks_hauls')->nullable();
            $table->decimal('net_line_length', 10, 2)->nullable();
            $table->decimal('soaking_time', 10, 2)->nullable();
            $table->decimal('mesh_size', 10, 2)->nullable();
            $table->integer('days_fished');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('fishing_location')->nullable();
            $table->string('payao_used')->nullable();
            $table->text('fishing_effort_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fishing_operations');
    }
};
