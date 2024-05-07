<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HeadUser extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'UserID',
        'password',
        'FName',
        'LName',
        'Email',
        'SexTypeID',
        'PostalCode',
        'FullAddress',
        'BDay',
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
}
