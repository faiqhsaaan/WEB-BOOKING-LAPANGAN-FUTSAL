<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_item_id',
        'lapangan_id',
        'rating',
        'date',
        'time',
        'comment',
    ];

    protected $table = 'feedback';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function bookingItem(){
        return $this->belongsTo(BookingItem::class);
    }

    public function lapangan(){
        return $this->belongsTo(Lapangan::class);
    }
}
