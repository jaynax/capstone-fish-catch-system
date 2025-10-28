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
            // Drop fishing operation related columns if they exist
            $columns = [
                'fishing_gear_type', 'gear_specifications', 'hooks_hauls',
                'net_line_length', 'soaking_time', 'mesh_size',
                'days_fished', 'fishing_location', 'payao_used',
                'fishing_effort_notes'
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
            $table->string('fishing_gear_type')->nullable()->after('weather_conditions');
            $table->text('gear_specifications')->nullable()->after('fishing_gear_type');
            $table->integer('hooks_hauls')->nullable()->after('gear_specifications');
            $table->decimal('net_line_length', 10, 2)->nullable()->after('hooks_hauls');
            $table->decimal('soaking_time', 8, 2)->nullable()->after('net_line_length');
            $table->decimal('mesh_size', 8, 2)->nullable()->after('soaking_time');
            $table->integer('days_fished')->nullable()->after('mesh_size');
            $table->string('fishing_location')->nullable()->after('days_fished');
            $table->string('payao_used')->nullable()->after('fishing_location');
            $table->text('fishing_effort_notes')->nullable()->after('payao_used');
        });
    }
};
