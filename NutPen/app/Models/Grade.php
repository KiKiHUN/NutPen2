<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = [
      'DateTime',
      'LessonID',
      'StudentID',
      'GradeTypeID'
    ];
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType="integer";
    public function GetGradeType()
      {
        return $this->belongsTo(GradeType::class,"GradeTypeID");
      }

      public function GetStudent()
      {
        return $this->belongsTo(Student::class,"StudentID");
      }


      public function GetLesson()
      {
        return $this->belongsTo(Lesson::class,"LessonID");
      }


      static function AddNewGradeToLesson($studentID,$lessonID,$gradeTypeID)
      {
        try {
          $c=new self;
          $c->LessonID=$lessonID;
          $c->DateTime=date('Y-m-d H:i:s');
          $c->StudentID=$studentID;
          $c->GradeTypeID=$gradeTypeID;
          $c->save();
        } catch (\Throwable $th) {
          return false;
        }
        return true;
      }

      static function EditGrade($gradeID,$gradeTypeID) 
      {
        $c=self::GetGradeIfExist($gradeID);
        if (!$c) {
          return false;
        }
        
        try {
          $c->GradeTypeID=$gradeTypeID;
          $c->save();
        } catch (\Throwable $th) {
          return false;
        }
        return true;
        
      }

      static function RemoveGrade($gradeID) 
      {
        $c=self::GetGradeIfExist($gradeID);
        if (!$c) {
          return false;
        }
        
        try {
          if ( DB::delete('DELETE FROM grades WHERE ID = ? ', [ $gradeID])) {
            return true;
        }else {
            return false;
          }
        } catch (\Throwable $th) {
          return false;
        }
        return true;
        
      }

      static function GetGradeIfExist($gradeID) 
      {
          $c=self::where([
            'ID' => $gradeID
          ])->first();
          if ($c) {
            return $c;
          }else {
            return null;
          }
      }
      
      static function GetGradeWithStudentIfExist($gradeID) 
      {
          $c=self::with('GetStudent')->where([
            'ID' => $gradeID
          ])->first();
          if ($c) {
            return $c;
          }else {
            return null;
          }
      }
}
