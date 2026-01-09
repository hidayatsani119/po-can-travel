<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'departure_city',
        'departure_terminal',
        'arrival_city',
        'arrival_terminal',
        'distance',
        'estimated_duration'
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
