<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Farmer extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'farmer_id';
    
    protected $fillable = [
        'farmer_name',
        'contact_number',
        'farm_location',
        'farm_size'
    ];

    protected $casts = [
        'farm_size' => 'decimal:2',
    ];

    public function harvests()
    {
        return $this->hasMany(Harvest::class, 'farmer_id');
    }
}
