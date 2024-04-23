<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = [
      'ID',
      'SubjectID',
      'StartDate',
      'EndDate',
      'Minutes',
      'WeeklyTimes',
      'TeacherID',
      'Active'
    ];
    protected $primaryKey = 'ID';
    public $incrementing = true;
    public function GetClasses()
    {
        return $this->hasManyThrough(SchoolClass::class,ClassesLessons::class,"LessonID","ID","ID","ClassID");
    }
    public function GetSubject()
    {
        return $this->belongsTo(Subject::class,'SubjectID');
    }
    public function GetTeacher()
    {
        return $this->belongsTo(Teacher::class,'TeacherID');
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
        return $this->hasMany(HomeWork::class,"LessonID");
    }

    static function AddNewLesson($subjectID,$startDate,$endDate,$minutes,$weeklyTimes,$teacherID,$active)
    {
      $serializedTimes = serialize($weeklyTimes);
      //dd(unserialize($serializedTimes));
     
      try 
      {
        $c=new self;
        $c->SubjectID=$subjectID;
        $c->StartDate=$startDate;
        $c->EndDate=$endDate;
        $c->Minutes=$minutes;
        $c->WeeklyTimes=$serializedTimes;
        $c->TeacherID=$teacherID;
        if ($active) {
          $c->Active=1;
        }else {
          $c->Active=0;
        }
       
        if ($c->save()) {
          return true;
        }else {
          return false;
        }
        
       
      } catch (\Throwable $th) {
        return false;
      }
     
    }

    static function EditLesson($lessonID,$subjectID,$startDate,$endDate,$minutes,$weeklyTimes,$teacherID,$active) 
    {
      
      $c=self::GetLessonIfExist($lessonID);
      if (!$c) {
       return false;
      }

      
      $serializedTimes = serialize($weeklyTimes);
      
      //dd(unserialize($serializedTimes));
      try 
      {
        $c->SubjectID=$subjectID;
        $c->TeacherID=$teacherID;
        $c->StartDate=$startDate;
        $c->EndDate=$endDate;
        $c->Minutes=$minutes;
        $c->WeeklyTimes=$serializedTimes;
        if ($active) {
          $c->Active=1;
        }else {
          $c->Active=0;
        }
        if ($c->save()) {
          return true;
        }else {
          return false;
        }
        
       
      } catch (\Throwable $th) {
        return false;
      }
      
    }
    static function GetLessonIfExist($lessonID) 
    {
        $c=self::where([
          'ID' => $lessonID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
