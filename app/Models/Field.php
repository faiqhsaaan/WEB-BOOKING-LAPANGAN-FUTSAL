<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'lapangan_id',
        'user_id',
        'name',
        'image',
        'description',
        'open_time',
        'close_time',
        'base_price',
        'discounted_price',
        'slot_duration',
    ];

    protected $table = 'fields';

    public function lapangan(){
        return $this->belongsTo(Lapangan::class);
    }

    public function jadwal(){
        return $this->hasMany(Jadwal::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function chart(){
        return $this->hasMany(Chart::class);
    }

    public function booking(){
        return $this->hasMany(Booking::class);
    }

    public function bookingItems(){
        return $this->hasMany(BookingItem::class);
    }

    public function discount(){
        return $this->hasOne(Discount::class);
    }

    public function priceRanges()
    {
        return $this->hasMany(PriceRange::class);
    }
}
