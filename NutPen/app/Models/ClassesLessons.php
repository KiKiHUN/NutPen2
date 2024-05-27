<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassesLessons extends Model
{
    use HasFactory;
    protected $fillable = [
      'LessonID',
      'ClassID'
    ];
    protected $primaryKey = ['ClassID', 'LessonID'];
    public $incrementing = false;
    public function GetSchoolClasses()
      {
        return $this->belongsToMany(SchoolClass::class,"ClassID");
      }
      public function GetLessons()
      {
        return $this->belongsToMany(Lesson::class,"LessonID");
      }

      static function AddClassToLesson($LessonID,$classID)
      {
        
        try {
          $c=new self;
          $c->LessonID=$LessonID;
          $c->ClassID=$classID;
         
          if ($c->save()) {
            return true;
          }else {
            return false;
          }
          
         
        } catch (\Throwable $th) {
          //dd($th);
          return false;
        }
       
      }

      static function RemoveClassFromLesson($lessonID,$classID) 
      {
        $c=self::GetConnectionIfExist($lessonID,$classID);
        
        if (!$c) {
         return false;
        }
        try {
          if ( DB::delete('DELETE FROM classes_lessons WHERE LessonID = ? AND ClassID = ?', [$lessonID, $classID])) {
              return true;
          }else {
              return false;
            }
         
        } catch (\Throwable $th) {
         return false;
        }
        
      }

      static function GetConnectionIfExist($lessonID,$classID) 
      {
          $c=self::where([
            'LessonID' => $lessonID,
            'ClassID'=>$classID
          ])->first();
          
          if ($c) {
            return $c;
          }else {
            return null;
          }
      }
}
