<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boat extends Model
{
    use HasFactory;

    protected $fillable = [
        'fish_catch_id',
        'boat_name',
        'boat_type',
        'boat_length',
        'boat_width',
        'boat_depth',
        'gross_tonnage',
        'horsepower',
        'engine_type',
        'fishermen_count'
    ];

    protected $casts = [
        'boat_length' => 'decimal:2',
        'boat_width' => 'decimal:2',
        'boat_depth' => 'decimal:2',
        'gross_tonnage' => 'decimal:2',
        'fishermen_count' => 'integer',
    ];

    public function fishCatch()
    {
        return $this->belongsTo(FishCatch::class);
    }
}