<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'lapangan_id',
        'user_id'
    ];

    public function lapangan(){
        return $this->belongsTo(Lapangan::class);
    }
}
