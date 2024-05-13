<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HomeWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'LessonID',
        'Name',
        'Description',
        'StartDateTime',
        'EndDateTime',
        'Active'
      ];
      protected $primaryKey = 'ID';
      public $incrementing = true;
      protected $keyType="integer";
   
    public function GetStudents()
    {
        return $this->hasManyThrough(Student::class,HomeWorkStudent::class,"HomeWorkID","UserID","ID","StudentID",);
    }
    public function GetLesson()
    {
        return $this->belongsTo(Lesson::class,"LessonID");
    }
   
    
    public function GetSubmittedHomeWorks() 
    {
      return $this->hasMany(HomeWorkStudent::class,"HomeWorkID");
    }
    static function RemoveHomework($homeworkID) 
    {
      $c=self::GetHomeworkIfExist($homeworkID);
      if (!$c) {
        return false;
      }
      
      try {
        if ( DB::delete('DELETE FROM home_works WHERE ID = ? ', [ $homeworkID])) {
          return true;
      }else {
          return false;
        }
      } catch (\Throwable $th) {
        return false;
      }
      return true;
      
    }

    static function AddNewHomework($lessonID,$name,$description,$startDate,$endDate,$active)
    {
      $c=null;
      try {
        $c=new self;
        $c->LessonID=$lessonID;
        $c->Name=$name;
        $c->Description=$description;
        $c->StartDateTime=$startDate;
        $c->EndDateTime=$endDate;
        $c->Active=$active;
        $c->save();
      } catch (\Throwable $th) {
       
        return false;
      }
      
      return true;
    }

    static function EditHomework($homeworkID,$lessonID,$name,$description,$startDate,$endDate,$active) 
    {
      $c=self::GetHomeworkIfExist($homeworkID);
      if (!$c) {
       return false;
      }
      
      try {
        $c->LessonID=$lessonID;
        $c->Name=$name;
        $c->Description=$description;
        $c->StartDateTime=$startDate;
        $c->EndDateTime=$endDate;
        $c->Active=$active;
      
        $c->save();

      } catch (\Throwable $th) {
       return false;
      }
      return true;
      
    }
    static function GetHomeworkIfExist($homeworkID) 
    {
        $c=self::where([
          'ID' => $homeworkID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
