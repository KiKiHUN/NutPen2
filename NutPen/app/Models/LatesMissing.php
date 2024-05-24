<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LatesMissing extends Model
{
    use HasFactory;
    protected $fillable = [
        'LessonID',
        'StudentID',
        'MissedMinute',
        'DateTime',
        'Verified',
        'VerifiedByID',
        'VerificationTypeID'
      ];
      protected $primaryKey = 'ID';
      public $incrementing = true;
      protected $keyType="integer";
    public function GetVerificationType()
    {
        return $this->belongsTo(VerificationType::class,"VerificationTypeID");
    }
    public function GetStudent()
    {
        return $this->belongsTo(Student::class,"StudentID");
    }
    public function GetLesson()
    {
        return $this->belongsTo(Lesson::class,"LessonID");
    }

    static function AddNewMissingToLesson($studentID,$lessonID,$minutes,$verificationTypeID=null)
    {
        
      try {
        $c=new self;
        $c->LessonID=$lessonID;
        $c->StudentID=$studentID;
        $c->MissedMinute=$minutes;
        if($verificationTypeID)
        {
            $c->Verified=1;
            $c->VerifiedByID=Auth::user()->UserID;
        }
        $c->VerificationTypeID=$verificationTypeID;
        $c->DateTime=date('Y-m-d H:i:s');
        $c->save();
      } catch (\Throwable $th) {
        return false;
      }
      return true;
    }

    static function EditMissing($missID,$minutes,$verificationTypeID) 
    {
       
      $verifiedupdated=false;
      $c=self::GetMissingIfExist($missID);
      if (!$c) {
        return false;
      }
      if ($c->VerificationTypeID!=$verificationTypeID) {
        $verifiedupdated=true;
      }
      if ($minutes==0) {
        if (!self::RemoveMissing($missID)) {
          return false;
        }
        return true;
      }

      try {
        $c->MissedMinute=$minutes;
        $c->VerificationTypeID=$verificationTypeID;
        if($verifiedupdated)
        {
            $c->Verified=1;
            $c->VerifiedByID=Auth::user()->UserID;
        }
       
        $c->save();
        
      } catch (\Throwable $th) {
        return false;
      }
      return true;
      
    }
    static function ParentEditMissing($missID) 
    {
       
     
      $c=self::GetMissingIfExist($missID);
      if (!$c) {
        return false;
      }
      $v=null;
      if (!($v=VerificationType::where("Name","=","Szülői igazolás")->first())) {
        return false;
      }
    
      $s=Student::where("USerID","=", $c->StudentID)->first();
      if ($s->RemainedParentVerification<=0) {
        return false;
      }
      try {
        $c->VerificationTypeID=$v->ID;
        $c->Verified=1;
        $c->VerifiedByID=Auth::user()->UserID;
        
        $s->RemainedParentVerification=$s->RemainedParentVerification-1;
        $c->save();
        $s->save();
      } catch (\Throwable $th) {
        return false;
      }
      return true;
      
    }

    static function RemoveMissing($missID) 
    {
      $c=self::GetMissingIfExist($missID);
      if (!$c) {
        return false;
      }
      
      try {
        if ( DB::delete('DELETE FROM lates_missings WHERE ID = ? ', [ $missID])) {
          return true;
      }else {
          return false;
        }
      } catch (\Throwable $th) {
        return false;
      }
      return true;
      
    }

    static function GetMissingIfExist($gradeID) 
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
    
    static function GetMissingWithStudentIfExist($gradeID) 
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
