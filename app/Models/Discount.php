<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'lapangan_id',
        'field_id',
        'user_id',
        'discount',
        'discounted_price',
    ];

    public function lapangan(){
        return $this->belongsTo(lapangan::class);
    }

    public function field(){
        return $this->belongsTo(Field::class);
    }
}
