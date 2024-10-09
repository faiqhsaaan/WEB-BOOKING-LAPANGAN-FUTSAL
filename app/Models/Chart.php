<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    protected $fillable = [
        'lapangan_id',
        'field_id',
        'jadwal_id',
        'user_id',
    ];

    public function lapangan(){
        return $this->belongsTo(Lapangan::class);
    }

    public function field(){
        return $this->belongsTo(Field::class);
    }

    public function jadwal(){
        return $this->belongsTo(Jadwal::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
