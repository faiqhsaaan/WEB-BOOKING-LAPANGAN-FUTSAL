<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'comment',
        'rating',
        'date',
        'time',
    ];

    protected $table = 'comments';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
