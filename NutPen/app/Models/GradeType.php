<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeType extends Model
{
    use HasFactory;
    public function GetGrades()
      {
        return $this->hasMany(Grade::class);
      }
}
