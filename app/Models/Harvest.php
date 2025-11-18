<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Harvest extends Model
{
    use HasFactory;

    protected $primaryKey = 'harvest_id';
    
    protected $fillable = [
        'farmer_id',
        'season',
        'planting_date',
        'harvest_date',
        'yield_amount',
        'variety_used'
    ];

    protected $casts = [
        'planting_date' => 'date',
        'harvest_date' => 'date',
        'yield_amount' => 'decimal:2',
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'farmer_id');
    }
}
