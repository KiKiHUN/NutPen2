<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicPermissionsType extends Model
{
    use HasFactory;
    public function GetPermissions()
    {
      return $this->hasMany(PublicPermissions::class);
    }
}
