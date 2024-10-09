<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lapangan_id',
        'image'
    ];

    public function lapangan(){
        return $this->belongsTo(Lapangan::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
