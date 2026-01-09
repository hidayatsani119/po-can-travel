<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'booking_code',
        'user_id',
        'trip_id',
        'seat_numbers',
        'passenger_count',
        'total_amount',
        'status',
        'notes'
    ];

    protected $casts = [
        'seat_numbers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Generate unique booking code
    public static function generateBookingCode()
    {
        do {
            $code = 'BB' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('booking_code', $code)->exists());

        return $code;
    }
}
