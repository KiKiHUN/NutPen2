<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bannertype extends Model
{
    use HasFactory;
    public function GetBannerMessages()
    {
        return $this->hasMany(BannerMsg::class);
    }
}
