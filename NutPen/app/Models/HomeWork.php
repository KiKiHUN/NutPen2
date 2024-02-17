<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeWork extends Model
{
    use HasFactory;
    public function GetStudents()
    {
        return $this->hasManyThrough(Student::class,HomeWorkStudent::class);
    }
    public function GetLesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
