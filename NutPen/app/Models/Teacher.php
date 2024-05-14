<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'UserID',
        'AllowMessages',
        'password',
        'FName',
        'LName',
        'Sex',
        'PostalCode',
        'FullAddress',
        'BDay',
        'TeachID',
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
        return $this->belongsTo(RoleType::class,"RoleTypeID");
      }
      public function GetSexType()
      {
        return $this->belongsTo(SexType::class,"SexTypeID");
      }
      public function GetOwnClasses()
      {
        return $this->hasMany(SchoolClass::class);
      }
      public function GetOwnLessons()
      {
        return $this->hasMany(Lesson::class);
      }
      public function GetWarnings()
      {
        return $this->hasMany(Warning::class);
      }
}
