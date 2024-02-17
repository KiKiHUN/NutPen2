<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\HeadUser;
use App\Models\Message;
use App\Models\Student;
use App\Models\StudParent;
use App\Models\Teacher;
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
                
                 return View('diak.diak_dashboard',['user'=>$user,'messages'=>$msg]);
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
                 return View('admin.admin_dashboard',['user'=>$user,'messages'=>$msg]);
                 break;
            case 'h':
                $user = HeadUser::where(['UserID' => Auth::user()->UserID])->first();
                if ( $this->DefaultCheck($user)) {
                    return redirect('/jelszoVisszaallitas');
                 }
                return View('admin.admin_dashboard',['user'=>$user,'messages'=>$msg]);
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
       
         $azonositoValaszto = mb_substr(Auth::user()->UserID, 0, 1);
 
         switch ($azonositoValaszto) {
            case 's':
                 $user=DB::table('students')->join('role_types', function ($join) {
                     $join->on('students.RoleTypeID', '=', 'role_types.ID')->where('students.UserID', '=', Auth::user()->UserID);
                 })->first();
                 return View('info',['user'=>$user]);
                 break;
            case 'h':
                $user=DB::table('head_users')->join('role_types', function ($join) {
                    $join->on('head_users.RoleTypeID', '=', 'role_types.ID')->where('head_users.UserID', '=', Auth::user()->UserID);
                })->first();
                return View('info',['user'=>$user]);
                break;
            case 'p':
                 $user=DB::table('stud_parents')->join('role_types', function ($join) {
                     $join->on('stud_parents.RoleTypeID', '=', 'role_types.ID')->where('stud_parents.UserID', '=', Auth::user()->UserID);
                 })->first();
 
                 return View('info',['user'=>$user]);
                 break;
            case 't':
                 $user=DB::table('teachers')->join('role_types', function ($join) {
                     $join->on('teachers.RoleTypeID', '=', 'role_types.ID')->where('teachers.UserID', '=', Auth::user()->UserID);
                 })->first();
                 return View('info',['user'=>$user]);
                 break;
            case 'a':
                 $user=DB::table('admins')->join('role_types', function ($join) {
                     $join->on('admins.RoleTypeID', '=', 'role_types.ID')->where('admins.UserID', '=', Auth::user()->UserID);
                 })->first();
                 return View('info',['user'=>$user]);
                 break;
         }
    }
}
