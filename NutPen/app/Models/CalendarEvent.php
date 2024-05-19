<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CalendarEvent extends Model
{
    use HasFactory;
    protected $fillable = [
      'CreatedByID',
      'Name',
      'Description',
      'StartDateTime',
      'EndDateTime',
      'Enabled'
    ];
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType="integer";
    public function GetRoleTypes()
      {
        return $this->hasManyThrough(RoleType::class,WhoCanSeeEvent::class,"CalendarEventID","ID","ID","RoleTypeID");
      }

      static function GetWhoGave($eventID)
    {
        $c=self::GetEventIfExist($eventID);
        if (!$c) {
            return null;
        }
        $azonositoValaszto = mb_substr($c->CreatedByID, 0, 1);
        $user=null;
        switch ($azonositoValaszto) {
            case 'a':
                $user = Admin::where([
                    'UserID' => $c->CreatedByID
                ])->first();
                break;
            case 't':
                $user = Teacher::where([
                    'UserID' => $c->CreatedByID
                ])->first();
                break;
            case 'h':
                $user = HeadUser::where([
                    'UserID' => $c->CreatedByID
                ])->first();
                break;
        }

        return $user;
        
    }

    static function RemoveEvent($eventID) 
    {
      $c=self::GetEventIfExist($eventID);
      if (!$c) {
        return false;
      }
      
      try {
        if ( DB::delete('DELETE FROM calendar_events WHERE ID = ? ', [ $eventID])) {
          return true;
      }else {
          return false;
        }
      } catch (\Throwable $th) {
        return false;
      }
      return true;
      
    }

    static function AddNewEvent($name,$description,$start,$end,$active,$CreatedByID,$roles)
    {
      

      DB::beginTransaction();

      try {
        $c=new self;
        $c->Name=$name;
        $c->Description=$description;
        $c->CreatedByID=$CreatedByID;
        $c->StartDateTime=$start;
        $c->EndDateTime=$end;
        $c->Enabled=$active;
        $c->save();
      } catch (\Throwable $th) {
        DB::rollBack();
        return false;
      }
      foreach ($roles as $key=> $value) {
          if ( ! WhoCanSeeEvent::AddNewCanSeeEvent($key,$c->ID)) {
              DB::rollBack();
              return false;
          }
      }

      DB::commit();
      
      return true;
    }

    static function EditEvent($eventID,$name,$description,$start,$end,$active,$CreatedByID,$roles) 
    {
        $c=self::GetEventWithRolesIfExist($eventID);
        if (!$c) {
        return false;
        }
        
        
        DB::beginTransaction();

        try {
          $c->Name=$name;
          $c->Description=$description;
          $c->CreatedByID=$CreatedByID;
          $c->StartDateTime=$start;
          $c->EndDateTime=$end;
          $c->Enabled=$active;
          $c->save();
        } catch (\Throwable $th) {
          DB::rollBack();
          return false;
        }

        $currentRoles = WhoCanSeeEvent::where('CalendarEventID', $eventID)
        ->pluck('RoleTypeID')
        ->toArray();

          // Determine roles to add and remove
        $rolesToAdd = array_diff(array_keys($roles), $currentRoles);
        $rolesToRemove = array_diff($currentRoles, array_keys($roles));

          // Remove roles that are no longer assigned
        foreach ($rolesToRemove as $roleID) {
            if ( !Whocanseeevent::RemoveCanSeeEvent($roleID, $eventID)) 
            {
              DB::rollBack();
              return false;
            }
            
        }

        // Add new roles
        foreach ($rolesToAdd as $roleID) {
          if (!Whocanseeevent::AddNewCanSeeEvent($roleID, $eventID)) 
          {
            DB::rollBack();
            return false;
          }
            
        }

       
      DB::commit();
        
      return true;
      
    }
    static function GetEventIfExist($eventID) 
    {
        $c=self::where([
          'ID' => $eventID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
    static function GetEventWithRolesIfExist($eventID) 
    {
        $c=self::with("GetRoleTypes")->where([
          'ID' => $eventID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
