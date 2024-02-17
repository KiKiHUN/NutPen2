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
}
