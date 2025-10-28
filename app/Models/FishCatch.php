<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishCatch extends Model
{
    use HasFactory;
    
    protected static function booted()
    {
        static::creating(function ($fishCatch) {
            \Log::info('Creating FishCatch record', [
                'attributes' => $fishCatch->attributes,
                'original' => $fishCatch->original
            ]);
        });
        
        static::created(function ($fishCatch) {
            \Log::info('FishCatch record created successfully', [
                'id' => $fishCatch->id,
                'attributes' => $fishCatch->attributes
            ]);
        });
    }

    protected $table = 'catches';

    protected $fillable = [
        // Fisherman Information
        'fisherman_registration_id',
        'fisherman_name',
        'user_id',
        
        // General Information
        'region',
        'landing_center',
        'date_sampling',
        'time_landing',
        'enumerators',
        'fishing_ground',
        'weather_conditions',
        
        // Fish Information
        'species',
        'scientific_name',
        'length_cm',
        'weight_g',
        'sex',
        'maturity',
        'stomach_content',
        'image_path',
        
        // Catch Details (stored as JSON)
        'catch_details',
        
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
        'catch_datetime',
        
        // Legacy fields for compatibility
        'latitude',
        'longitude',
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

    /**
     * Get the boat associated with the fish catch.
     */
    public function boat()
    {
        return $this->hasOne(Boat::class, 'catch_id');
    }

    /**
     * Get the fishing operation associated with the fish catch.
     */
    public function fishingOperation() 
    {
        return $this->hasOne(FishingOperation::class, 'catch_id');
    }
    
    public function boats()
    {
        return $this->hasMany(Boat::class);
    }
    
    public function fishingOperations()
    {
        return $this->hasMany(FishingOperation::class);
    }
}
