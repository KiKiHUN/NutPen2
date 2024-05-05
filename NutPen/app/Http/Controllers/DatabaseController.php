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
use Illuminate\Support\Facades\File;

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
        try {
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

        } catch (\Throwable $th) {
            return false;
        }
        DB::beginTransaction();
        try {
            $r=new RoleType();
            $r->Name="Admin";
            $r->Description="Minden kezelő";
            $r->save();
            $r=new RoleType();
            $r->Name="Tanár";
            $r->Description="Tanító";
            $r->save();
            $r=new RoleType();
            $r->Name="Diák";
            $r->Description="Tanuló";
            $r->save();
            $r=new RoleType();
            $r->Name="Szülő";
            $r->Description="Tanuló gondviselője";
            $r->save();
            $r=new RoleType();
            $r->Name="Fő felhasználó";
            $r->Description="igazgató/irodai dolgozó";
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
    
            $l=new bannertype();
            $l->typename="LoginBanner";
            $l->save();
    
            $p=new PublicPermissionsType();
            $p->RoleName="EnableOverallLogin";
            $p->save();
    
            $pp=new PublicPermissions();
            $pp->PermissionType=1;
            $pp->status=0;
            $pp->save();
           
            Config::set('CFG_IsFirstRun', true);
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
       
    }

    public static function EndYearBackup()
    {
        $type=PublicPermissionsType::where('RoleName','=','EnableOverallLogin')->first();
        if ($type) {
            $pp=PublicPermissions::where('PermissionType', '=', $type->ID)->latest()->first();
            $pp->status=1;
            $pp->save();
        }
     

        $currentSessionId = session()->getId();
        $directory = storage_path('framework/sessions');

        // Get all files in the directory
        $files = glob($directory . '/*');

        // Loop through each file and delete it if it's not the current session ID
        foreach($files as $file) {
            if(is_file($file) && basename($file) !== $currentSessionId) {
                unlink($file);
            }
        }

        $folderStructurePath = storage_path().'\app\SChoolYearBackup';

        if (! File::exists($folderStructurePath)) {
            if (!File::makeDirectory($folderStructurePath)) {
                return redirect()->back()->with('failedmessage', "Sikertelen mentés, szerver IO hiba");
            }
        }
        // Generate a filename for the SQL dump
        $filename = date('Ym').'_backup_' . date('Ymd_His') . '.sql';

        // Path to store the backup file
        $outfilepath = $folderStructurePath ."\\". $filename;

        // Path to store the backup file
        $folderPath = storage_path().'\mysqlFiles';

        // Database configuration
        $dbHost = env('DB_HOST');
        $dbPort = env('DB_PORT');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        // Path to mysqldump.exe
        $mysqldumpPath = $folderPath . "\\" . 'mysqldump.exe';

        // Generate mysqldump command
        $command = sprintf(
            '"%s" --host=%s --port=%s --user=%s --password=%s --skip-ssl %s > %s',
            $mysqldumpPath,
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName),
            escapeshellarg($outfilepath)
        );

        

        // Execute mysqldump command
        exec($command, $output, $returnVar);

        // Check if the command was executed successfully
        if ($returnVar === 0) {
            if ( self::EndYearNuke()) {
                if ($type) {
                    $pp=PublicPermissions::where('PermissionType', '=', $type->ID)->latest()->first();
                    $pp->status=0;
                    $pp->save();
                }
                return true;
            }else 
            {
                return  false;
            }
        } else {
           
            return  false;
        }
    }

    static function EndYearNuke() 
    {

       $returnvar=false;
        DB::statement("SET foreign_key_checks=0");
        try {
            CalendarEvent::truncate();
            Grade::truncate(); 
            HomeWork::truncate();
            HomeWorkStudent::truncate();
            LatesMissing::truncate();
            Lesson::truncate();
            $returnvar=true;
        } catch (\Throwable $th) {
            return false;
            DB::rollBack();
        }
        DB::statement("SET foreign_key_checks=1");
        $students=Student::all();
       
        DB::beginTransaction();
        foreach ( $students as $student ) {
            $student->RemainedParentVerification=3;
          
            try {
                $student->save();
                $returnvar=true;
            } catch (\Throwable $th) {
                $returnvar=false;
                DB::rollBack();
                break;
            }
          
        } 
        DB::commit();
        return $returnvar;
     
       
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
