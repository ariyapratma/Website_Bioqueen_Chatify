<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroFaq extends Model
{
    use HasFactory;

    protected $table = 'hero_faq';

    protected $fillable = ['question', 'answer'];
}
