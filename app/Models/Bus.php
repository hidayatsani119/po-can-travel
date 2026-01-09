<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'plate_number',
        'type',
        'total_seats',
        'facilities',
        'status'
    ];

    protected $casts = [
        'facilities' => 'array',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
