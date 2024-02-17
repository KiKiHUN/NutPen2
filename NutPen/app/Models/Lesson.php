<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    public function GetClasses()
    {
        return $this->hasManyThrough(SchoolClass::class,ClassesLessons::class);
    }
    public function GetSubject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function GetTeacher()
    {
        return $this->hasOne(Teacher::class);
    }
    public function GetGrades()
    {
        return $this->hasMany(Grade::class);
    }
    public function GetLatesMissings()
    {
        return $this->hasMany(LatesMissing::class);
    }
    public function GetHomeworks()
    {
        return $this->hasMany(HomeWork::class);
    }
}
