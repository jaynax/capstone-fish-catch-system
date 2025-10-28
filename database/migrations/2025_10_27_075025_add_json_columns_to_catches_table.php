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
        Schema::table('catches', function (Blueprint $table) {
            $table->json('boat_info')->nullable()->after('weather_conditions');
            $table->json('fishing_operation')->nullable()->after('boat_info');
            $table->json('catch_details')->nullable()->after('fishing_operation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catches', function (Blueprint $table) {
            $table->dropColumn(['boat_info', 'fishing_operation', 'catch_details']);
        });
    }
};
