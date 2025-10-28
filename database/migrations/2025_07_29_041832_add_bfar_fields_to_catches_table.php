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
            // General Information
            $table->string('region')->nullable();
            $table->string('fisherman_registration_id');
            $table->string('fisherman_name');
            $table->string('landing_center');
            $table->date('date_sampling');
            $table->time('time_landing');
            $table->string('enumerators');
            $table->string('fishing_ground');
            $table->string('weather_conditions');
            
            // Boat Information
            $table->string('boat_type');
            $table->boolean('is_motorized')->default(true);
            $table->decimal('boat_length', 8, 2);
            $table->decimal('boat_width', 8, 2);
            $table->decimal('boat_depth', 8, 2);
            $table->decimal('gross_tonnage', 10, 2)->nullable();
            $table->integer('horsepower')->nullable();
            $table->string('engine_type')->nullable();
            $table->integer('fishermen_count');
            
            // Fishing Operation Details
            $table->string('fishing_gear_type');
            $table->text('gear_specifications')->nullable();
            $table->integer('hooks_hauls')->nullable();
            $table->decimal('net_line_length', 10, 2)->nullable();
            $table->decimal('soaking_time', 5, 2)->nullable();
            $table->decimal('mesh_size', 5, 2)->nullable();
            $table->integer('days_fished');
            $table->string('fishing_location');
            $table->boolean('payao_used')->default(false);
            $table->text('fishing_effort_notes')->nullable();
            
            // Catch Information
            $table->enum('catch_type', ['Complete', 'Incomplete', 'Partly Sold']);
            $table->decimal('total_catch_kg', 10, 2);
            $table->boolean('subsample_taken')->default(false);
            $table->decimal('subsample_weight', 10, 2)->nullable();
            $table->boolean('below_legal_size')->default(false);
            $table->string('below_legal_species')->nullable();
            
            // AI Species Recognition & Size Estimation
            $table->string('scientific_name')->nullable();
            $table->decimal('confidence_score', 5, 2)->nullable();
            $table->decimal('detection_confidence', 5, 2)->nullable();
            $table->integer('bbox_width')->nullable();
            $table->integer('bbox_height')->nullable();
            $table->decimal('pixels_per_cm', 10, 4)->nullable();
            $table->decimal('fish_length_cm', 8, 2)->nullable();
            $table->decimal('fish_weight_g', 10, 2)->nullable();
            
            // Image Processing
            $table->string('processing_mode')->default('automatic');
            
            // Existing fields
            $table->decimal('latitude', 10, 7)->nullable()->change();
            $table->decimal('longitude', 10, 7)->nullable()->change();
            $table->dateTime('catch_datetime')->nullable()->change();
            $table->string('gear_type')->nullable()->change();
            $table->integer('catch_volume')->nullable()->change();
            $table->text('remarks')->nullable()->change();
            $table->string('image_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catches', function (Blueprint $table) {
            // Remove BFAR fields
            $table->dropColumn([
                'region', 'fisherman_registration_id', 'fisherman_name', 'landing_center', 
                'date_sampling', 'time_landing', 'enumerators', 'fishing_ground', 'weather_conditions',
                'boat_type', 'is_motorized', 'boat_length', 'boat_width', 'boat_depth', 
                'gross_tonnage', 'horsepower', 'engine_type', 'fishermen_count', 'fishing_gear_type', 
                'gear_specifications', 'hooks_hauls', 'net_line_length', 'soaking_time', 'mesh_size', 
                'days_fished', 'fishing_location', 'payao_used', 'fishing_effort_notes', 'catch_type', 
                'total_catch_kg', 'subsample_taken', 'subsample_weight', 'below_legal_size', 
                'below_legal_species', 'scientific_name', 'confidence_score', 'detection_confidence', 
                'bbox_width', 'bbox_height', 'pixels_per_cm', 'fish_length_cm', 'fish_weight_g',
                'processing_mode'
            ]);
        });
    }
};
