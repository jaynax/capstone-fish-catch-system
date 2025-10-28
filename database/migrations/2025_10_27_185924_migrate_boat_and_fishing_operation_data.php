<?php

use App\Models\FishCatch;
use App\Models\Boat;
use App\Models\FishingOperation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Process each fish catch record
        $catches = FishCatch::whereNotNull('boat_info')
            ->orWhereNotNull('fishing_operation')
            ->get();

        foreach ($catches as $catch) {
            // Migrate boat info if it exists
            if ($catch->boat_info) {
                $boatData = json_decode($catch->boat_info, true);
                if (is_array($boatData)) {
                    Boat::create([
                        'catch_id' => $catch->id,
                        'boat_name' => $boatData['boat_name'] ?? null,
                        'boat_type' => $boatData['boat_type'] ?? null,
                        'boat_length' => $boatData['boat_length'] ?? null,
                        'boat_width' => $boatData['boat_width'] ?? null,
                        'boat_depth' => $boatData['boat_depth'] ?? null,
                        'gross_tonnage' => $boatData['gross_tonnage'] ?? null,
                        'horsepower' => $boatData['horsepower'] ?? null,
                        'engine_type' => $boatData['engine_type'] ?? null,
                        'fishermen_count' => $boatData['fishermen_count'] ?? null,
                    ]);
                }
            }

            // Migrate fishing operation if it exists
            if ($catch->fishing_operation) {
                $operationData = json_decode($catch->fishing_operation, true);
                if (is_array($operationData)) {
                    FishingOperation::create([
                        'catch_id' => $catch->id,
                        'fishing_gear_type' => $operationData['fishing_gear_type'] ?? null,
                        'gear_specifications' => $operationData['gear_specifications'] ?? null,
                        'hooks_hauls' => $operationData['hooks_hauls'] ?? null,
                        'net_line_length' => $operationData['net_line_length'] ?? null,
                        'soaking_time' => $operationData['soaking_time'] ?? null,
                        'mesh_size' => $operationData['mesh_size'] ?? null,
                        'days_fished' => $operationData['days_fished'] ?? null,
                        'latitude' => $operationData['latitude'] ?? null,
                        'longitude' => $operationData['longitude'] ?? null,
                        'fishing_location' => $operationData['fishing_location'] ?? null,
                        'payao_used' => $operationData['payao_used'] ?? null,
                        'fishing_effort_notes' => $operationData['fishing_effort_notes'] ?? null,
                    ]);
                }
            }
        }

        // Now add the foreign key constraints
        DB::statement('ALTER TABLE boats MODIFY catch_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE fishing_operations MODIFY catch_id BIGINT UNSIGNED NOT NULL');

        Schema::table('boats', function ($table) {
            $table->foreign('catch_id')
                  ->references('id')
                  ->on('catches')
                  ->onDelete('cascade');
        });

        Schema::table('fishing_operations', function ($table) {
            $table->foreign('catch_id')
                  ->references('id')
                  ->on('catches')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove foreign key constraints first
        Schema::table('boats', function ($table) {
            $table->dropForeign(['catch_id']);
        });

        Schema::table('fishing_operations', function ($table) {
            $table->dropForeign(['catch_id']);
        });

        // Set catch_id back to nullable
        Schema::table('boats', function ($table) {
            $table->unsignedBigInteger('catch_id')->nullable()->change();
        });

        Schema::table('fishing_operations', function ($table) {
            $table->unsignedBigInteger('catch_id')->nullable()->change();
        });
  
    }
};