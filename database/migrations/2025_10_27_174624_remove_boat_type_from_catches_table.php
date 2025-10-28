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
        // Check if the column exists before trying to remove it
        if (Schema::hasColumn('catches', 'boat_type')) {
            Schema::table('catches', function (Blueprint $table) {
                $table->dropColumn('boat_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add the column back if we need to rollback
        if (!Schema::hasColumn('catches', 'boat_type')) {
            Schema::table('catches', function (Blueprint $table) {
                $table->string('boat_type')->nullable()->after('fishing_ground');
            });
        }
    }
};
