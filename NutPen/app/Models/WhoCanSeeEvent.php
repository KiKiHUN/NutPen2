<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhoCanSeeEvent extends Model
{
    use HasFactory;
    public function GetEvent()
    {
        return $this->belongsTo(CalendarEvent::class);
    }
    public function GetRoles()
    {
        return $this->belongsTo(RoleType::class);
    }
}
