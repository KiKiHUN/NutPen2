<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;
    public function GetOwnParents()
    {
        return $this->belongsToMany(StudParent::class);
    }
    public function GetOwnStudents()
    {
        return $this->belongsToMany(Student::class);
    }
}
