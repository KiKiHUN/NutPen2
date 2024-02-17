<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationType extends Model
{
    use HasFactory;
    public function GetLatesMissings()
    {
        return $this->hasMany(LatesMissing::class);
    }
}
