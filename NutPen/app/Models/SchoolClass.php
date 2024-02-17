<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;
    public function GetTeacher()
      {
        return $this->belongsTo(Teacher::class);
      }
      public function GetStudents()
      {
        return $this->hasManyThrough(Student::class,StudentsClass::class);
      }
      public function GetLessons()
      {
        return $this->hasManyThrough(Lesson::class,ClassesLessons::class);
      }
}
