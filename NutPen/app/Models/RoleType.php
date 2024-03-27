<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleType extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'Description'
      ];
      protected $primaryKey = 'ID';
      public $incrementing = true;
      protected $keyType="integer";
    public function GetHeadUsers()
    {
        return $this->hasMany(HeadUser::class);
    }
    public function GetAdmins()
    {
        return $this->hasMany(Admin::class);
    }
    public function GetStudParents()
    {
        return $this->hasMany(StudParent::class);
    }
    public function GetStudents()
    {
        return $this->hasMany(Student::class);
    }
    public function GetTeachers()
    {
        return $this->hasMany(Teacher::class);
    }
    public function GetEvents()
    {
        return $this->hasManyThrough(CalendarEvent::class,WhoCanSeeEvent::class);
    }


    static function AddNewRole($name)
    {
      try {
        $c=new self;
        $c->Name=$name;
        $c->save();
      } catch (\Throwable $th) {
        return false;
      }
      return true;
    }

    static function EditRole($roleID,$name) 
    {
      $c=self::GetRoleIfExist($roleID);
      if (!$c) {
       return false;
      }
      
      try {
        $c->Name=$name;
        $c->save();
      } catch (\Throwable $th) {
       return false;
      }
      return true;
      
    }
    static function GetRoleIfExist($roleID) 
    {
        $c=self::where([
          'ID' => $roleID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
