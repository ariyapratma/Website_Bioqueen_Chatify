<?php

namespace App\Models;

use App\Models\User;
use Chatify\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class ChFavorite extends Model
{
    use UUID;

    protected $table = 'ch_favorites';

    /**
     * Relasi dengan pengguna yang menambahkan favorit.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi dengan pengguna atau entitas yang menjadi favorit.
     */
    public function favorite()
    {
        return $this->belongsTo(User::class, 'favorite_id');
    }
}
