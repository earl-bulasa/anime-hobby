<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ThemeSong;

class Anime extends Model
{
    use HasFactory;

    public function theme_songs()
    {
        return $this->hasMany(ThemeSong::class);
    }
}
