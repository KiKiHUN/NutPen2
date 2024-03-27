<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GradeType extends Model
{
    use HasFactory;
    protected $fillable = [
      'Name',
      'Value'
    ];
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType="integer";
    public function GetGrades()
    {
      return $this->hasMany(Grade::class,'GradeTypeID');
    }

    static function AddNewGrade($name,$value)
    {
      try {
        $c=new self;
        $c->Name=$name;
        $c->Value=$value;
        $c->save();
      } catch (\Throwable $th) {
        return false;
      }
      return true;
    }

    static function EditGrade($gradeID,$name,$value) 
    {
      $c=self::GetGradeIfExist($gradeID);
      if (!$c) {
        return false;
      }
      
      try {
        $c->Name=$name;
        $c->Value=$value;
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
        if ( DB::delete('DELETE FROM grade_types WHERE ID = ? ', [ $gradeID])) {
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
}
