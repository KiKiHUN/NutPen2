<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassesLessons extends Model
{
    use HasFactory;
    public function GetSchoolClasses()
      {
        return $this->belongsToMany(SchoolClass::class);
      }
      public function GetLessons()
      {
        return $this->belongsToMany(Lesson::class);
      }
}
