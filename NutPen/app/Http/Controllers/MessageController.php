<?php

namespace App\Http\Controllers;

use App\Models\BannerMsg;
use App\Models\bannertype;
use App\Models\Lesson;
use App\Models\Message;
use App\Models\RoleType;
use App\Models\Student;
use App\Models\StudentsClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use DateTime;
use PHPUnit\Framework\MockObject\Builder\Stub;

class MessageController extends Controller
{
    public function GetLoginBannerMessage()
    {
        $type=bannertype::where('typename','=','LoginBanner')->first();
        $msg=BannerMsg::where('messageTypeID', '=', $type->ID)->where("Enabled","=",1)->latest()->first();
        if ( $msg->Enabled==0) {
            return response( null,200);
        }
        $file=null;
        if ($msg->ImagePath) 
        {
            $file=asset("storage/images/LoginBanner/{$msg->ImagePath}");

        }
        $data = [
            'header'  =>  $msg->Header,
            'file'   => $file,
            'description' => $msg->Description
        ];

        $json= json_encode( $data, JSON_UNESCAPED_SLASHES );
        //error_log(  $json);
        return response( $json,200);
    }

    public function Savemsg(Request $request)
    {
        if (Auth::user()->UserID!=$request->SenderID) {
            return response("Neem szabad felhasználó ID-t módosítani",69);
        }

        $satus=Message::SendMSG($request->message,$request->SenderID,$request->TargetID);
        if ($satus==0) 
        {
            return response()->json(['status'=>0,'message' => 'új üzenet llétrehozva'], 200);
        }elseif ($satus==1) {
            return response()->json(['status'=>1,'message' => 'Cél ID nem található'], 200);
        }else{
            return response()->json(['status'=>2,'message' => 'Sikertelen mentés'], 200);
        }

    }

    function Calendar(){
        $roleevents=RoleType::with("GetEvents")->where("ID",Auth::user()->RoleTypeID)->first();
        
        $events = [];
        foreach ($roleevents->GetEvents as $event ) {
            $startdate = new DateTime($event->StartDateTime);
            $enddate = new DateTime($event->EndDateTime);
            $c=new CalendarData();
            $c->start= $startdate->format('U');
            $c->end= $enddate->format('U');
            $c->title=$event->Name;
            $c->content= $event->Description;
            $c->category= 'Esemény';
            $events[] = $c;
        }
        
        $UserID=Auth::user()->UserID;
        $azonositoValaszto = mb_substr($UserID, 0, 1);
        switch ($azonositoValaszto) {
        case 'a':
            
             
             break;
        case 's':
                $classConnections=StudentsClass::with(['GetClass.GetLessons.GetSubject','GetClass.GetLessons.GetTeacher'])->where('StudentID','=', Auth::user()->UserID)->get();
            
                foreach ($classConnections as $class ) {
                
                    foreach ($class->GetClass->GetLessons as $lesson) {
                        $unserializedData = unserialize($lesson->WeeklyTimes);
                        // Start date
                        $currentDate = new DateTime($lesson->StartDate);
                        
                        // End date
                        $endDate = new DateTime($lesson->EndDate);
                        $endDate->modify('+1 day');
                    
                        while ($currentDate <= $endDate) {
        
                            $dayOfWeek = $currentDate->format('l');
        
                            if ($unserializedData[$dayOfWeek]) {
                                $startTime = $unserializedData[$dayOfWeek];
                            
        
                                list($hours, $minutes) = explode(':', $startTime);
                                $currentDate->setTime($hours, $minutes);
                            
        
                                $endDateTime = clone $currentDate;
                                $endDateTime->modify('+' . $lesson->Minutes . ' minutes');
        
        
                                $c=new CalendarData();
                                $c->start= $currentDate->format('U');
                                $c->end= $endDateTime->format('U');
                                $c->title=$lesson->GetSubject->Name;
                                $c->content='Tanár: '.$lesson->GetTeacher->FName." ".$lesson->GetTeacher->LName;
                                $c->category= 'Tanóra';
                                $events[] = $c;
                            }
                        
                            $currentDate->modify('+1 day');
                        }   
                    } 
                }
        break;
        case 't':
            $lessonsWithdSubject=Lesson::with(["GetSubject"])->where("TeacherID","=",Auth::user()->UserID)->get();
            foreach ( $lessonsWithdSubject as $lesson) {
                $unserializedData = unserialize($lesson->WeeklyTimes);
                // Start date
                $currentDate = new DateTime($lesson->StartDate);
                
                // End date
                $endDate = new DateTime($lesson->EndDate);
                $endDate->modify('+1 day');
            
                while ($currentDate <= $endDate) {

                    $dayOfWeek = $currentDate->format('l');

                    if ($unserializedData[$dayOfWeek]) {
                        $startTime = $unserializedData[$dayOfWeek];
                    

                        list($hours, $minutes) = explode(':', $startTime);
                        $currentDate->setTime($hours, $minutes);
                    

                        $endDateTime = clone $currentDate;
                        $endDateTime->modify('+' . $lesson->Minutes . ' minutes');


                        $c=new CalendarData();
                        $c->start= $currentDate->format('U');
                        $c->end= $endDateTime->format('U');
                        $c->title=$lesson->GetSubject->Name;
                        $c->content='Tanár: '.$lesson->GetTeacher->FName." ".$lesson->GetTeacher->LName;
                        $c->category= 'Tanóra';
                        $events[] = $c;
                    }
                
                    $currentDate->modify('+1 day');
                }   
                
            }
        break;
        case 'p':
          
             break;
        case 'h':
             
             break;
        }
      
        $json= json_encode(  $events, JSON_UNESCAPED_SLASHES );
        //error_log(  $json);
        return response()->json(['status'=>0,'message' => 'Sikeres módosítás','data'=>  $json], 200);
    }
    function CalendarOnStudent($studentID){
        $user=Student::where("USerID",$studentID)->first();
        $roleevents=RoleType::with("GetEvents")->where("ID",$user->RoleTypeID)->first();
        
        $events = [];
        foreach ($roleevents->GetEvents as $event ) {
            $startdate = new DateTime($event->StartDateTime);
            $enddate = new DateTime($event->EndDateTime);
            $c=new CalendarData();
            $c->start= $startdate->format('U');
            $c->end= $enddate->format('U');
            $c->title=$event->Name;
            $c->content= $event->Description;
            $c->category= 'Esemény';
            $events[] = $c;
        }
        
        $classConnections=StudentsClass::with(['GetClass.GetLessons.GetSubject','GetClass.GetLessons.GetTeacher'])->where('StudentID','=', $studentID)->get();
    
        foreach ($classConnections as $class ) {
        
            foreach ($class->GetClass->GetLessons as $lesson) {
                $unserializedData = unserialize($lesson->WeeklyTimes);
                // Start date
                $currentDate = new DateTime($lesson->StartDate);
                
                // End date
                $endDate = new DateTime($lesson->EndDate);
                $endDate->modify('+1 day');
            
                while ($currentDate <= $endDate) {

                    $dayOfWeek = $currentDate->format('l');

                    if ($unserializedData[$dayOfWeek]) {
                        $startTime = $unserializedData[$dayOfWeek];
                    

                        list($hours, $minutes) = explode(':', $startTime);
                        $currentDate->setTime($hours, $minutes);
                    

                        $endDateTime = clone $currentDate;
                        $endDateTime->modify('+' . $lesson->Minutes . ' minutes');


                        $c=new CalendarData();
                        $c->start= $currentDate->format('U');
                        $c->end= $endDateTime->format('U');
                        $c->title=$lesson->GetSubject->Name;
                        $c->content='Tanár: '.$lesson->GetTeacher->FName." ".$lesson->GetTeacher->LName;
                        $c->category= 'Tanóra';
                        $events[] = $c;
                    }
                
                    $currentDate->modify('+1 day');
                }   
            } 
        }
       
     
      
        $json= json_encode(  $events, JSON_UNESCAPED_SLASHES );
        //error_log(  $json);
        return response()->json(['status'=>0,'message' => 'Sikeres módosítás','data'=>  $json], 200);
    }
    function CalendarLesson($lessonID) 
    {
        $lesson=Lesson::with(["GetTeacher","GetSubject"])->where('ID', '=', $lessonID)->first();
        
        $events = [];

        $unserializedData = unserialize($lesson->WeeklyTimes);
    
        // Start date
        $currentDate = new DateTime($lesson->StartDate);
        
        // End date
        $endDate = new DateTime($lesson->EndDate);
        $endDate->modify('+1 day');
    
        while ($currentDate <= $endDate) {

            $dayOfWeek = $currentDate->format('l');

            if ($unserializedData[$dayOfWeek]) {
                $startTime = $unserializedData[$dayOfWeek];
            

                list($hours, $minutes) = explode(':', $startTime);
                $currentDate->setTime($hours, $minutes);
            

                $endDateTime = clone $currentDate;
                $endDateTime->modify('+' . $lesson->Minutes . ' minutes');


                $c=new CalendarData();
                $c->start= $currentDate->format('U');
                $c->end= $endDateTime->format('U');
                $c->title=$lesson->GetSubject->Name;
                $c->content='Tanár: '.$lesson->GetTeacher->FName." ".$lesson->GetTeacher->LName;
                $c->category= 'Tanóra';


                $events[] = $c;
            }
        
            $currentDate->modify('+1 day');
        } 
       

        $json= json_encode(  $events, JSON_UNESCAPED_SLASHES );
        //error_log(  $json);
        return response()->json(['status'=>0,'message' => 'Sikeres módosítás','data'=>  $json], 200);
       
    }

    
}
class CalendarData
{
    public $start="";
    public $end="";
    public $title=null;
    public $content=null;
    public $category=null;
}