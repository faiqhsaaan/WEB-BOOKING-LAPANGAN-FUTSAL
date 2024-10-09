<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class lapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'facilities',
        'location',
        'province_id',
        'regencies_id',
        'price',
        'description',
        'photos',
        'calender'
    ];

    public function province()
    {
        return $this->belongsTo(province::class);
    }

    public function regencies()
    {
        return $this->belongsTo(Regency::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function field(){
        return $this->hasMany(Field::class);
    }

    public function chart(){
        return $this->hasMany(Chart::class);
    }

    public function gallery(){
        return $this->hasMany(Gallery::class);
    }

    public function booking(){
        return $this->hasMany(Booking::class);
    }

    public function bookingItem(){
        return $this->hasMany(BookingItem::class);
    }

    public function discount(){
        return $this->hasMany(Discount::class);
    }

    public function promotion(){
        return $this->hasMany(Promotion::class);
    }

    public function feedback(){
        return $this->hasMany(Feedback::class);
    }
    
}
