<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'UserID',
        'password',
        'FName',
        'LName',
        'Sex',
        'PostalCode',
        'FullAddress',
        'BDay',
        'BPlace',
        'StudentCardNum',
        'StudentTeachID',
        'Email',
        'Phone',
        'RoleTypeID',
        'LastLogin',
        'DefaultPassword'
      ];
      protected $primaryKey = 'UserID';
      public $incrementing = false;
      protected $keyType="string";
      public function GetRole()
      {
        return $this->belongsTo(RoleType::class);
      }
      public function GetSexType()
      {
        return $this->belongsTo(SexType::class);
      }
      public function GetOwnWarnings()
      {
        return $this->hasMany(Warning::class);
      }
      public function GetOwnParents()
      {
        return $this->hasManyThrough(StudParent::class,StudentParent::class);
      }
      public function GetOwnClass()
      {
        return $this->hasOneThrough(SchoolClass::class,StudentsClass::class);
      }
      public function GetOwnGrades()
      {
        return $this->hasMany(Grade::class);
      }
      public function GetOwnLatesMissings()
      {
        return $this->hasMany(LatesMissing::class);
      }
      public function GetOwnHomeworks()
      {
        return $this->hasMany(HomeWorkStudent::class);
      }
}