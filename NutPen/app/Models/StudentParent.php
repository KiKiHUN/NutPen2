<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudentParent extends Model
{
    use HasFactory;
    protected $fillable = [
        'StudentID',
        'ParentID'
      ];
      protected $primaryKey = ['StudentID', 'ParentID'];
    public $incrementing = false;
    public function GetParent()
    {
        return $this->belongsTo(StudParent::class,"ParentID");
    }
    public function GetStudent()
    {
        return $this->belongsTo(Student::class,"StudentID");
    }



    static function AddNewStudPar($StudentID,$parentid)
    {

      try {
        $c=new self;
        $c->StudentID=$StudentID;
        $c->ParentID=$parentid;
        if ($c->save()) {
          return true;
        }else {
          return false;
        }
        
       
      } catch (\Throwable $th) {
        return false;
      }
     
    }
    static function RemoveStudPar($StudentID,$parentid) {
      $c=self::GetStudParIfExist($StudentID,$parentid);
      
      if (!$c) {
       return false;
      }
      try {
        if ( DB::delete('DELETE FROM student_parents WHERE StudentID = ? AND ParentID = ?', [$StudentID,$parentid])) {
            return true;
        }else {
            return false;
          }
       
      } catch (\Throwable $th) {
        //dd($th);
       return false;
      }
      
    }
    static function GetStudParIfExist($StudentID,$parentid) 
    {
        $c=self::where([
          'StudentID' => $StudentID,
          'ParentID'=>$parentid
        ])->first();
        
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
