<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profile_image',
        'name',
        'email',
        'phone',
        'role',
        'sosmed',
        'prefrences',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function lapangan(){
        return $this->hasMany(lapangan::class);
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

    public function feedback(){
        return $this->hasMany(Feedback::class);
    }

    public function jadwal(){
        return $this->hasMany(Jadwal::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
