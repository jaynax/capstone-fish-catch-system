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
            // Drop boat-related columns if they exist
            $columns = [
                'boat_type', 'boat_name', 'boat_length', 
                'boat_width', 'boat_depth', 'gross_tonnage',
                'horsepower', 'engine_type', 'fishermen_count'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('catches', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catches', function (Blueprint $table) {
            // Add the columns back if we need to rollback
            $table->string('boat_type')->nullable()->after('fishing_ground');
            $table->string('boat_name')->nullable()->after('boat_type');
            $table->decimal('boat_length', 8, 2)->nullable()->after('boat_name');
            $table->decimal('boat_width', 8, 2)->nullable()->after('boat_length');
            $table->decimal('boat_depth', 8, 2)->nullable()->after('boat_width');
            $table->decimal('gross_tonnage', 10, 2)->nullable()->after('boat_depth');
            $table->integer('horsepower')->nullable()->after('gross_tonnage');
            $table->string('engine_type')->nullable()->after('horsepower');
            $table->integer('fishermen_count')->nullable()->after('engine_type');
        });
    }
};
