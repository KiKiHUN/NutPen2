<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;
    protected $fillable = [
      'ID',
      'Name',
      'ClassMasterID'
    ];
    protected $primaryKey = 'ID';
    public $incrementing = true;
    
    public function GetTeacher()
    {
      return $this->belongsTo(Teacher::class, 'ClassMasterID');
    }
    public function GetStudents()
    {
      return $this->hasManyThrough(Student::class,StudentsClass::class,"ClassID","UserID","ID","StudentID");
    }
    public function GetLessons()
    {
      return $this->hasManyThrough(Lesson::class,ClassesLessons::class,"ClassID","ID","ID","LessonID");
    }



    static function AddNewClass($name,$teacherID)
    {
      try {
        $c=new self;
        $c->Name=$name;
        $c->ClassMasterID=$teacherID;
        if ($c->save()) {
          return true;
        }else {
          return false;
        }
        
       
      } catch (\Throwable $th) {
        return false;
      }
     
    }

    static function EditClass($classID,$name,$teacher) 
    {
      $c=self::GetCllassIfExist($classID);
      if (!$c) {
       return false;
      }
      
      try {
        $c->Name=$name;
        $c->ClassMasterID=$teacher;
        $c->save();
      } catch (\Throwable $th) {
       return false;
      }
      return true;
      
    }
    static function GetCllassIfExist($classID) 
    {
        $c=self::where([
          'ID' => $classID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
