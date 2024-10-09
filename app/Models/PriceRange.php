<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceRange extends Model
{
    use HasFactory;

    protected $fillable = ['field_id', 'start_time', 'end_time', 'price'];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
