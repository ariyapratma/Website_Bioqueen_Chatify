<?php

namespace App\Models;

use App\Models\User;
use Chatify\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class ChMessage extends Model
{
    use UUID;

    protected $table = 'ch_messages';

    /**
     * Relasi dengan pengguna yang mengirim pesan.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    /**
     * Relasi dengan pengguna yang menerima pesan.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
