<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WhoCanSeeEvent extends Model
{
    use HasFactory;
    protected $fillable = [
        'RoleTypeID',
        'CalendarEventID'
      ];
      protected $primaryKey = ['CalendarEventID', 'RoleTypeID'];
    public $incrementing = false;
    public function GetEvent()
    {
        return $this->belongsTo(CalendarEvent::class,"CalendarEventID");
    }
    public function GetRoles()
    {
        return $this->belongsTo(RoleType::class,"RoleTypeID");
    }

   
    static function AddNewCanSeeEvent($RoleTypeID,$CalendarEventID)
    {

      try {
        $c=new self;
        $c->RoleTypeID=$RoleTypeID;
        $c->CalendarEventID=$CalendarEventID;
        if ($c->save()) {
          return true;
        }else {
          return false;
        }
        
       
      } catch (\Throwable $th) {
        return false;
      }
     
    }


    static function RemoveCanSeeEvent($RoleTypeID,$CalendarEventID) 
    {
      $c=self::GetCanSeeEventIfExist($RoleTypeID,$CalendarEventID);
      
      if (!$c) {
        return false;
      }
      try {
        if ( DB::delete('DELETE FROM who_can_see_events WHERE RoleTypeID = ? AND CalendarEventID = ?', [$RoleTypeID,$CalendarEventID])) {
            return true;
        }else {
            return false;
        }
      
      } catch (\Throwable $th) {
        //dd($th);
        return false;
      }
    
    }


    static function GetCanSeeEventIfExist($RoleTypeID,$CalendarEventID) 
    {
        $c=self::where([
          'RoleTypeID' => $RoleTypeID,
          'CalendarEventID'=>$CalendarEventID
        ])->first();
        
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
