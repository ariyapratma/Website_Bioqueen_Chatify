<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\ChMessage;
use App\Models\ChFavorite;
use App\Models\Notification;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi dengan Cart (satu user bisa memiliki banyak cart items).
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the user's avatar or return a default one.
     */
    public function getAvatarAttribute($value)
    {
        return $value ?? asset('storage/avatars/default.png');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Relasi dengan ChMessage (satu user bisa mengirim banyak pesan).
     */
    public function sentMessages()
    {
        return $this->hasMany(ChMessage::class, 'from_id');
    }

    /**
     * Relasi dengan ChMessage (satu user bisa menerima banyak pesan).
     */
    public function receivedMessages()
    {
        return $this->hasMany(ChMessage::class, 'to_id');
    }

    /**
     * Relasi dengan ChFavorite (satu user bisa menambahkan banyak favorite items).
     */
    public function favorites()
    {
        return $this->hasMany(ChFavorite::class, 'user_id');
    }

    /**
     * Relasi dengan ChFavorite (satu user bisa menjadi favorite dari banyak user).
     */
    public function favoritedBy()
    {
        return $this->hasMany(ChFavorite::class, 'favorite_id');
    }
}
