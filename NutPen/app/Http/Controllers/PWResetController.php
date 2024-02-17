<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\HeadUser;
use App\Models\Student;
use App\Models\StudParent;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PWResetController extends Controller
{
   

    function SavePW(Request $request)
    {
        $UserID=Auth::user()->UserID;
        $pw=$request->post('password');
        //dd($azonosito);
        //dd($jelszo); //jok ezek
        $AzonositoValaszto = mb_substr($UserID, 0, 1);
        $user=null;
        switch ($AzonositoValaszto) {
            case 'h':
                $user= HeadUser::findOrFail($UserID);
                break;
            case 'a':
                $user= Admin::findOrFail($UserID);
                break;
            case 's':
                $user= Student::findOrFail($UserID);
                break;
            case 'p':
                $user= StudParent::findOrFail($UserID);
                break;
            case 't':
                $user= Teacher::findOrFail($UserID);
                break;
        }


        if ($user)
        {
            $user->password =$this->hasheles( $pw);
            $user->DefaultPassword =false;
            try {
                $user->save();
            } catch (\Exception $e) {
                echo(" <script>alert('Sikertelen módosítás'); </script>");
                return redirect('/jelszoVisszaallitas');
            }
            $this->registerGuard( $AzonositoValaszto, $user);
            echo(" <script>alert('Sikeres módosítás'); </script>");
            return redirect('/vezerlopult');
        }else {
            echo(" <script>alert('Sikertelen módosítás'); </script>");
            return redirect('/jelszoVisszaallitas');
        }

        //return view('flights.show',['flight'=>$flight]);
    }
    
    function hasheles($be)
    {
        $prefix = '$2y$';
        $cost = '10';
        $salt = '$GodLuckCrackingThePW69$';
        $blowfishPrefix = $prefix.$cost.$salt;
        $password = $be;
        $hash = crypt($password, $blowfishPrefix);
       return  $hash;
    }

    function registerGuard($firstChar,$user)
    {
        switch ($firstChar) {
            case 'h':
                Auth::guard('headUser')->login($user);
                break;
            case 'a':
                Auth::guard('admin')->login($user);
                break;
            case 's':
                Auth::guard('student')->login($user);
                break;
            case 'p':
                Auth::guard('parent')->login($user);
                break;
            case 't':
                Auth::guard('teacher')->login($user);
                break;
        }
       
    }
}
