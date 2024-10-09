<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice',
        'date',
        'time',
        'name',
        'phone',
        'total_price',
        'status',
        'payment_url',
        'payment_method', 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookingItems(){
        return $this->hasMany(BookingItem::class);
    }

    public function jadwal(){
        return $this->belongsTo(Jadwal::class);
    }
}
