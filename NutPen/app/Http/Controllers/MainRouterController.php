<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Grade;
use App\Models\HeadUser;
use App\Models\HomeWork;
use App\Models\HomeWorkStudent;
use App\Models\Message;
use App\Models\RoleType;
use App\Models\SchoolClass;
use App\Models\SexType;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\StudentsClass;
use App\Models\StudParent;
use App\Models\Teacher;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainRouterController extends Controller
{
    public function Dash()
    {
   
     
         $firstCharacter = mb_substr(Auth::user()->UserID, 0, 1);
        
         $msg=null;
        
         switch ($firstCharacter) {
            case 's':
               $user = Student::where(['UserID' => Auth::user()->UserID])->first();
               if ( $this->DefaultCheck($user)) {
               return redirect('/jelszoVisszaallitas');
               }
               if (  $user->AllowMessages==1) {
                    $msg= Message::getTopXMessagesByID(Auth::user()->UserID,10);
               }
            
               
               $oneWeekAgo = now()->subWeek();
               $warnings=Warning::where('StudentID','=',Auth::user()->UserID)->where('DateTime','>=',$oneWeekAgo)->get();
               $wariningswithUsers = [];
              
               // Loop through each student in the class
               foreach ($warnings as $warning) {
                    
                    $whogave=Warning::GetWhoGave($warning->ID);
                    $wariningswithUsers[$warning->ID] = [
                         'ID' => $warning->ID,
                         'name' => $warning->Name,
                         'whogavename' => $whogave->LName." ". $whogave->FName,
                         'whogaveID' => $warning->WhoGaveID
                    ];
               }
               $ratings=Grade::with(['GetLesson.GetSubject','GetGradeType'])->where('StudentID','=',Auth::user()->UserID)->where('DateTime','>=',$oneWeekAgo)->get();
               
               return View('userviews.student.dashboard',['user'=>$user,'messages'=>$msg,'newwarnings'=>$wariningswithUsers,'newratings'=>$ratings]);
               break;
            case 'p':
               $user = StudParent::where(['UserID' => Auth::user()->UserID])->first();
               if ( $this->DefaultCheck($user)) {
               return redirect('/jelszoVisszaallitas');
               }
               if (  $user->AllowMessages==1) {
                    $msg= Message::getTopXMessagesByID(Auth::user()->UserID,10);
               }
               
               $ownchilds=StudentParent::where('ParentID','=',Auth::user()->UserID)->get();


               $oneWeekAgo = now()->subWeek();
               $warnings=[];
               $ratings=[];
               foreach ( $ownchilds as $child ) {
                    $warnings[]=Warning::where('StudentID','=',$child->StudentID)->where('DateTime','>=',$oneWeekAgo)->get();
                    $ratings[]=Grade::with(['GetLesson.GetSubject','GetGradeType','GetStudent'])->where('StudentID','=',$child->StudentID)->where('DateTime','>=',$oneWeekAgo)->get();
                   
               }
               $wariningswithUsers = [];

               if ( count($warnings)>0) {
                    // Loop through each student in the class
                    foreach ($warnings as $warning) {
                         foreach ($warning as $onewarning) {
                              $whogave=Warning::GetWhoGave($onewarning->ID);
                              $student=Student::where("UserID","=",$onewarning->StudentID)->first();
                              $wariningswithUsers[$onewarning->ID] = [
                                   'ID' => $onewarning->ID,
                                   'name' => $onewarning->Name,
                                   'whogavename' => $whogave->FName." ". $whogave->LName,
                                   'whogaveID' => $onewarning->WhoGaveID,
                                   'childName' => $student->FName." ". $student->LName
                              ];
                         }
                    }
               }
              
               
               return View('userviews.parent.dashboard',['user'=>$user,'messages'=>$msg,'newwarnings'=>$wariningswithUsers,'newratings'=>$ratings]);



                
                 break;
            case 't':
                 $user = Teacher::where(['UserID' => Auth::user()->UserID])->first();
                 if ( $this->DefaultCheck($user)) {
                    return redirect('/jelszoVisszaallitas');
                 }
                 if (  $user->AllowMessages==1) {
                    $msg= Message::getTopXMessagesByID(Auth::user()->UserID,10);
               }
                 $classes=SchoolClass::where("ClassMasterID","=",Auth::user()->UserID)->get();


                 

                 $newhomeworks=HomeWork::whereHas('GetLesson', function ($query) {
                    return $query->where('TeacherID', '=', Auth::user()->UserID);
                })->withCount(['GetSubmittedHomeWorks' => function ($query) {
                    $query->where('SubmitDateTime', '>=', now()->subWeek());
                }])
                ->get();

               
                  
            
               return View('userviews.teacher.dashboard',['user'=>$user,"newhomeworks"=>$newhomeworks,'messages'=>$msg,'ownclasses'=>$classes]);
               break;
            case 'a':
                 $user = Admin::where(['UserID' => Auth::user()->UserID])->first();
                 if ( $this->DefaultCheck($user)) {
                    return redirect('/jelszoVisszaallitas');
                 }
                 if (  $user->AllowMessages==1) {
                    $msg= Message::getTopXMessagesByID(Auth::user()->UserID,10);
               }
                 return View('userviews.admin.admin_dashboard',['user'=>$user,'messages'=>$msg]);
                 break;
            case 'h':
                $user = HeadUser::where(['UserID' => Auth::user()->UserID])->first();
                if ( $this->DefaultCheck($user)) {
                    return redirect('/jelszoVisszaallitas');
                 }
                 if (  $user->AllowMessages==1) {
                    $msg= Message::getTopXMessagesByID(Auth::user()->UserID,10);
               }
                return View('userviews.headuser.dashboard',['user'=>$user,'messages'=>$msg]);
                break;
         }
    }

    function DefaultCheck($user)
    {
          if ($user->DefaultPassword) {
               return true;
          }
       return false;
    }

    function PWResetPage()
    {
        return view('reset',['UserID'=>Auth::user()->UserID]);
    }
    
    public function Profile()
    {
          $UserID=Auth::user()->UserID;
          $u=null;
          $aditionalAttrinutes=null;

          $azonositoValaszto = mb_substr($UserID, 0, 1);
          switch ($azonositoValaszto) {
          case 'a':
               $user = Admin::with(["GetRole","GetSexType"])->where([
                    'UserID' => $UserID
               ])->first();
               
               break;
          case 's':
               $user = Student::with(["GetRole","GetSexType"])->where([
                    'UserID' => $UserID
               ])->first();
               $aditionalAttrinutes = [
                    'bPlace' => $user->BPlace,
                    'studentCardNum' => $user->StudentCardNum,
                    'studentTeachID' => $user->StudentTeachID,
                    'remainingVerifications'=>$user->RemainedParentVerification
               ];
               break;
          case 't':
               $user = Teacher::with(["GetRole","GetSexType"])->where([
                    'UserID' => $UserID
               ])->first();
               $aditionalAttrinutes = [
                    'teachID' => $user->TeachID
               ];
               break;
          case 'p':
               $user = StudParent::with(["GetRole","GetSexType"])->where([
                    'UserID' => $UserID
               ])->first();
               break;
          case 'h':
               $user = HeadUser::with(["GetRole","GetSexType"])->where([
                    'UserID' => $UserID
               ])->first();
               break;
          }
          $additionalAttributesJson = json_encode($aditionalAttrinutes);
     
          if ($user)
          {
          return view('info',['user'=>$user,'aditionals'=>$additionalAttributesJson]);
          }else {
          return redirect()->back()->with('failedmessage', "Azonosító nem található");
          }

        
    }

    public function MsgstatusEdit() 
    {
          $UserID=Auth::user()->UserID;
          $u=null;
          $aditionalAttrinutes=null;

          $azonositoValaszto = mb_substr($UserID, 0, 1);
          switch ($azonositoValaszto) {
          case 'a':
               $user = Admin::where([
                    'UserID' => $UserID
               ])->first();
               
               break;
          case 's':
               $user = Student::where([
                    'UserID' => $UserID
               ])->first();
               break;
          case 't':
               $user = Teacher::where([
                    'UserID' => $UserID
               ])->first();
               break;
          case 'p':
               $user = StudParent::where([
                    'UserID' => $UserID
               ])->first();
               break;
          case 'h':
               $user = HeadUser::where([
                    'UserID' => $UserID
               ])->first();
               break;
          }
        

          if ($user)
          {
               try {
                    if ( $user->AllowMessages==1) {
                         $user->AllowMessages=0;
                    }else
                    {
                         $user->AllowMessages=1;
                    }
                    $user->save();
                    return redirect()->back()->with('successmessage', "Sikeres módosítás");
               } catch (\Throwable $th) {
                    return redirect()->back()->with('failedmessage', "Hiba a mentés során");
               }
          
          }else {
            return redirect()->back()->with('failedmessage', "Azonosító nem található");
          }

    }

    


}
