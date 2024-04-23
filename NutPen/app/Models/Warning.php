<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Warning extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'Description',
        'DateTime',
        'WhoGaveID',
        'StudentID'
      ];
      protected $primaryKey = 'ID';
      public $incrementing = true;
      protected $keyType="integer";
   
    public function GetStudent()
    {
        return $this->belongsTo(Student::class,"StudentID");
    }

    static function GetWhoGave($warningID)
    {
        $c=self::GetWarningIfExist($warningID);
        if (!$c) {
            return null;
        }
        $azonositoValaszto = mb_substr($c->WhoGaveID, 0, 1);
        $user=null;
        switch ($azonositoValaszto) {
            case 'a':
                $user = Admin::where([
                    'UserID' => $c->WhoGaveID
                ])->first();
                break;
            case 't':
                $user = Teacher::where([
                    'UserID' => $c->WhoGaveID
                ])->first();
                break;
            case 'h':
                $user = HeadUser::where([
                    'UserID' => $c->WhoGaveID
                ])->first();
                break;
        }

        return $user;
        
    }

    static function RemoveWarning($warningID) 
    {
      $c=self::GetWarningIfExist($warningID);
      if (!$c) {
        return false;
      }
      
      try {
        if ( DB::delete('DELETE FROM warnings WHERE ID = ? ', [ $warningID])) {
          return true;
      }else {
          return false;
        }
      } catch (\Throwable $th) {
        return false;
      }
      return true;
      
    }

    static function AddNewWarning($name,$description,$whogaveID,$studentID)
    {
      try {
        $c=new self;
        $c->Name=$name;
        $c->Description=$description;
        $c->WhoGaveID=$whogaveID;
        $c->StudentID=$studentID;
        $c->DateTime=date('Y-m-d H:i:s');
        $c->save();
      } catch (\Throwable $th) {
        dd($th);
        return false;
      }
      return true;
    }

    static function EditWarning($warningID,$name,$description,$studentID) 
    {
      $c=self::GetWarningIfExist($warningID);
      if (!$c) {
       return false;
      }
      
      try {
        $c->Name=$name;
        $c->Description=$description;
        $c->StudentID=$studentID;
        $c->DateTime=date('Y-m-d H:i:s');
      
        $c->save();

      } catch (\Throwable $th) {
       return false;
      }
      return true;
      
    }
    static function GetWarningIfExist($warningID) 
    {
        $c=self::where([
          'ID' => $warningID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
