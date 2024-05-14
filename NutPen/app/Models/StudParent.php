<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StudParent extends Authenticatable
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
        'Email',
        'Phone',
        'RoleTypeID',
        'AllowMessages',
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
      public function GetOwnStudents()
      {
          return $this->hasManyThrough(Student::class,StudentParent::class);
      }
}
