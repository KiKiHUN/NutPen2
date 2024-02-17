<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SexType extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'Description',
        'Title'
      ];
      protected $primaryKey = 'ID';
      public $incrementing = true;
      protected $keyType="integer";

    public static function getSexes()
    {
        return self::all();
    }


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
}
