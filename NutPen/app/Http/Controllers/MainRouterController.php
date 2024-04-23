<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Grade;
use App\Models\HeadUser;
use App\Models\Message;
use App\Models\RoleType;
use App\Models\SexType;
use App\Models\Student;
use App\Models\StudParent;
use App\Models\Teacher;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainRouterController extends Controller
{
    public function Dash()
    {
         $firstCharacter = mb_substr(Auth::user()->UserID, 0, 1);
         $msg=Message::getTopXMessagesByID(Auth::user()->UserID,10);
         switch ($firstCharacter) {
            case 's':
               $user = Student::where(['UserID' => Auth::user()->UserID])->first();
               if ( $this->DefaultCheck($user)) {
               return redirect('/jelszoVisszaallitas');
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
                 return View('szulo.szulo_dashboard',['user'=>$user,'messages'=>$msg]);
                 break;
            case 't':
                 $user = Teacher::where(['UserID' => Auth::user()->UserID])->first();
                 if ( $this->DefaultCheck($user)) {
                    return redirect('/jelszoVisszaallitas');
                 }
                 return View('tanar.tanar_dashboard',['user'=>$user,'messages'=>$msg]);
                 break;
            case 'a':
                 $user = Admin::where(['UserID' => Auth::user()->UserID])->first();
                 if ( $this->DefaultCheck($user)) {
                    return redirect('/jelszoVisszaallitas');
                 }
                 return View('userviews.admin.admin_dashboard',['user'=>$user,'messages'=>$msg]);
                 break;
            case 'h':
                $user = HeadUser::where(['UserID' => Auth::user()->UserID])->first();
                if ( $this->DefaultCheck($user)) {
                    return redirect('/jelszoVisszaallitas');
                 }
                return View('userviews.admin.admin_dashboard',['user'=>$user,'messages'=>$msg]);
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
}
