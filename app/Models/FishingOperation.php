<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishingOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'fish_catch_id',
        'fishing_gear_type',
        'gear_specifications',
        'hooks_hauls',
        'net_line_length',
        'soaking_time',
        'mesh_size',
        'days_fished',
        'latitude',
        'longitude',
        'fishing_location',
        'payao_used',
        'fishing_effort_notes'
    ];

    protected $casts = [
        'hooks_hauls' => 'integer',
        'net_line_length' => 'decimal:2',
        'soaking_time' => 'decimal:2',
        'mesh_size' => 'decimal:2',
        'days_fished' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    public function fishCatch()
    {
        return $this->belongsTo(FishCatch::class);
    }
}