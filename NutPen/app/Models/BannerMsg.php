<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerMsg extends Model
{
    use HasFactory;
    public function GetType()
    {
        return $this->belongsTo(bannertype::class);
    }
}
