<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bannertype extends Model
{
    use HasFactory;
    protected $fillable = [
        'typename'
      ];
      protected $primaryKey = 'ID';
      public $incrementing = true;
      protected $keyType="integer";
    public function GetBannerMessages()
    {
        return $this->hasMany(BannerMsg::class,"messageTypeID");
    }
}
