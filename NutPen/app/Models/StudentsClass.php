<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsClass extends Model
{
    use HasFactory;
    public function GetClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
    public function GetStudents()
    {
        return $this->belongsToMany(Student::class);
    }
}
