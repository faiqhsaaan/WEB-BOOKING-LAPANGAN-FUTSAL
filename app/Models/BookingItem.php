<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lapangan_id',
        'field_id',
        'jadwal_id',
        'booking_id'
    ];

    protected $table = 'booking_items';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function lapangan(){
        return $this->belongsTo(Lapangan::class);
    }

    public function field(){
        return $this->belongsTo(Field::class);
    }

    public function jadwal(){
        return $this->belongsTo(Jadwal::class);
    }

    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
