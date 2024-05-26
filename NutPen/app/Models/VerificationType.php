<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VerificationType extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'Description'
      ];
      protected $primaryKey = 'ID';
      public $incrementing = true;
      protected $keyType="integer";
    public function GetLatesMissings()
    {
        return $this->hasMany(LatesMissing::class,"VerificationTypeID");
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

    static function AddNewVerif($name,$description)
    {
      try {
        $c=new self;
        $c->Name=$name;
        $c->Description=$description;
        $c->save();
      } catch (\Throwable $th) {
        
        return false;
      }
      return true;
    }

    static function EditVerif($verifID,$name,$description) 
    {
      $c=self::GetVerifIfExist($verifID);
     
      if (!$c) {
      
        return false;
      }
      
      try {
        $c->Name=$name;
        $c->Description=$description;
        $c->save();
      } catch (\Throwable $th) {
       
        return false;
      }
      return true;
      
    }

    static function RemoveGrade($verifID) 
    {
      $c=self::GetVerifIfExist($verifID);
      if (!$c) {
        return false;
      }
      
      try {
        if ( DB::delete('DELETE FROM verification_types WHERE ID = ? ', [ $verifID])) {
          return true;
      }else {
          return false;
        }
      } catch (\Throwable $th) {
        return false;
      }
      return true;
      
    }
    
    static function GetVerifIfExist($verifID) 
    {
     
        $c=self::where([
          'ID' => $verifID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
