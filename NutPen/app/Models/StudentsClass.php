<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudentsClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'StudentID',
        'ClassID'
      ];
    protected $primaryKey = ['StudentID', 'ClassID'];
    public $incrementing = false;
    public function GetClass()
    {
        return $this->belongsTo(SchoolClass::class,"ClassID");
    }
    public function GetStudents()
    {
        return $this->belongsToMany(Student::class,"StudentID");
    }
    static function AddNewStudent($ClassID,$StudentID)
    {

      try {
        $c=new self;
        $c->StudentID=$StudentID;
        $c->ClassID=$ClassID;
        if ($c->save()) {
          return true;
        }else {
          return false;
        }
        
       
      } catch (\Throwable $th) {
        return false;
      }
     
    }
    static function RemoveStudentFromClass($classID,$studentID) 
    {
      $c=self::GetConnectionIfExist($studentID,$classID);
      
      if (!$c) {
       return false;
      }
      try {
        if ( DB::delete('DELETE FROM students_classes WHERE StudentID = ? AND ClassID = ?', [$studentID, $classID])) {
            return true;
        }else {
            return false;
          }
       
      } catch (\Throwable $th) {
        dd($th);
       return false;
      }
      
    }
    static function GetConnectionIfExist($studentID,$classID) 
    {
        $c=self::where([
          'StudentID' => $studentID,
          'ClassID'=>$classID
        ])->first();
        
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
