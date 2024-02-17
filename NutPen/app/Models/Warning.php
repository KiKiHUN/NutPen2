<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    use HasFactory;
    public function GetTeacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function GetStudent()
    {
        return $this->belongsTo(Student::class);
    }
}
