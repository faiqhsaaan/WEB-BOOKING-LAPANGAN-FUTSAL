<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_id',
        'user_id',
        'name',
        'date',
        'start_time',
        'end_time',
        'status',
        'price',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function chart(){
        return $this->hasMany(Chart::class);
    }

    public function bookingItem(){
        return $this->hasMany(BookingItem::class);
    }

    public function booking(){
        return $this->hasMany(Booking::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
