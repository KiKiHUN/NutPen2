<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeWorkStudent extends Model
{
    use HasFactory;
    public function GetStudents()
    {
        return $this->belongsToMany(Student::class);
    }
    public function GetHomeworks()
    {
        return $this->belongsToMany(HomeWork::class);
    }
}
