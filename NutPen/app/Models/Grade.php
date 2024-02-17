<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    public function GetGradeType()
      {
        return $this->belongsTo(GradeType::class);
      }
      public function GetStudent()
      {
        return $this->belongsTo(Student::class);
      }
      public function GetLesson()
      {
        return $this->belongsTo(Lesson::class);
      }
}
