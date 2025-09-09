<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishCatch extends Model
{
    use HasFactory;

    protected $table = 'catches';

    protected $fillable = [
        // Fisherman Information
        'fisherman_registration_id',
        'fisherman_name',
        
        // General Information
        'region',
        'landing_center',
        'date_sampling',
        'time_landing',
        'enumerators',
        'fishing_ground',
        'weather_conditions',
        
        // Boat Information
        'boat_name',
        'boat_type',
        'boat_length',
        'boat_width',
        'boat_depth',
        'gross_tonnage',
        'horsepower',
        'engine_type',
        'fishermen_count',
        
        // Fishing Operation Details
        'fishing_gear_type',
        'gear_specifications',
        'hooks_hauls',
        'net_line_length',
        'soaking_time',
        'mesh_size',
        'days_fished',
        'fishing_location',
        'payao_used',
        'fishing_effort_notes',
        
        // Catch Information
        'catch_type',
        'total_catch_kg',
        'subsample_taken',
        'subsample_weight',
        'below_legal_size',
        'below_legal_species',
        
        // AI Species Recognition & Size Estimation
        'species',
        'scientific_name',
        'length_cm',
        'weight_g',
        'confidence_score',
        'detection_confidence',
        'bbox_width',
        'bbox_height',
        'pixels_per_cm',
        
        // Legacy fields for compatibility
        'latitude',
        'longitude',
        'catch_datetime',
        'gear_type',
        'catch_volume',
        'remarks',
        'image_path',
        'user_id',
    ];

    protected $casts = [
        'date_sampling' => 'date',
        'time_landing' => 'datetime',
        'boat_length' => 'decimal:2',
        'boat_width' => 'decimal:2',
        'boat_depth' => 'decimal:2',
        'gross_tonnage' => 'decimal:2',
        'net_line_length' => 'decimal:2',
        'soaking_time' => 'decimal:2',
        'mesh_size' => 'decimal:2',
        'total_catch_kg' => 'decimal:2',
        'subsample_weight' => 'decimal:2',
        'pixels_per_cm' => 'decimal:4',
        'length_cm' => 'decimal:1',
        'weight_g' => 'decimal:1',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
