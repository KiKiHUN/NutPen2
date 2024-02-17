<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BannedIP;
use App\Models\BannerMsg;
use App\Models\bannertype;
use App\Models\CalendarEvent;
use App\Models\ClassesLessons;
use App\Models\Grade;
use App\Models\GradeType;
use App\Models\HeadUser;
use App\Models\HomeWork;
use App\Models\HomeWorkStudent;
use App\Models\LatesMissing;
use App\Models\Lesson;
use App\Models\Message;
use App\Models\PublicPermissions;
use App\Models\PublicPermissionsType;
use App\Models\PushSub;
use App\Models\RoleType;
use App\Models\SchoolClass;
use App\Models\SchoolInfo;
use App\Models\SexType;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\StudentsClass;
use App\Models\StudParent;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\VerificationType;
use App\Models\Warning;
use App\Models\WhoCanSeeEvent;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseController extends Controller
{
    public static function IsFirstRun()
    {
        if (Config::get('CFG_IsFirstRun')==null) {
            if(Admin::all()->count()==0)
            {
                Config::set('CFG_IsFirstRun', true);
                return true;
            }else
            {
                Config::set('CFG_IsFirstRun', false);
                return false;
            }
        }elseif(Config::get('CFG_IsFirstRun')==false)
        {
            return false;
        }else {
            return true;
        }
        
    }
    public static function DefaultValues() 
    {
        DB::statement("SET foreign_key_checks=0");

        Admin::truncate();
        BannedIP::truncate();
        BannerMsg::truncate();
        bannertype::truncate();
        CalendarEvent::truncate();
        ClassesLessons::truncate();
        Grade::truncate();
        GradeType::truncate();
        HeadUser::truncate();
        HomeWork::truncate();
        HomeWorkStudent::truncate();
        LatesMissing::truncate();
        Lesson::truncate();
        Message::truncate();
        PushSub::truncate();
        SchoolClass::truncate();
        SchoolInfo::truncate();
        Student::truncate();
        StudentParent::truncate();
        StudentsClass::truncate();
        StudParent::truncate();
        Subject::truncate();
        Teacher::truncate();
        VerificationType::truncate();
        Warning::truncate();
        WhoCanSeeEvent::truncate();
        RoleType::truncate();
        SexType::truncate();
        PublicPermissionsType::truncate();
        PublicPermissions::truncate();

        DB::statement("SET foreign_key_checks=1");

        $r=new RoleType();
        $r->Name="admin";
        $r->Description="Minden kezelő";
        $r->save();

        $s=new SexType();
        $s->Name="Férfi";
        $s->Title="Mr.";
        $s->Description="Férfinak születtet, férfinak nevezi magát";
        $s->save();

        $s=new SexType();
        $s->Name="Nő";
        $s->Title="Mrs.";
        $s->Description="Nőnek született nőnek nevezi magát";
        $s->save();

        $p=new PublicPermissionsType();
        $p->RoleName="EnableOverallLogin";
        $p->save();

        $pp=new PublicPermissions();
        $pp->PermissionType=1;
        $pp->status=0;
        $pp->save();

        
    }


    public static function ChechkIfAllowedToLogin(){
        $type=PublicPermissionsType::where('RoleName','=','EnableOverallLogin')->first();
        if ($type) {
            $enabled=PublicPermissions::where('PermissionType', '=', $type->ID)->latest()->first();
            if($enabled->status==0)
            {
                return(true);
            }
        }

        return(false);
    }

    
}
