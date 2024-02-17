<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatesMissing extends Model
{
    use HasFactory;
    public function GetVerificationType()
    {
        return $this->belongsTo(VerificationType::class);
    }
    public function GetStudent()
    {
        return $this->belongsTo(VerificationType::class);
    }
    public function GetLesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
