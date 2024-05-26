<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DatabaseController;
use App\Models\Admin;
use App\Models\SexType;
use Illuminate\Http\Request;
use App\CustomClasses\PwHasher;
use Carbon\Carbon;
use DateTime;

class RegisterController extends Controller
{
    function SetupPage()
    {
        if (DatabaseController::IsFirstRun()) {
            DatabaseController::DefaultValues();
            return view('userviews.admin.admin_register',['sexes'=>SexType::getSexes()]);
        }else {
            return redirect('/');
        }
    }
    function RegisterAdmin(Request $request){
        if (DatabaseController::IsFirstRun()) {
            $a=new Admin();
            $a->UserID=$request->userid;
            $a->password=PwHasher::hasheles($request->password);
            $a->FName=$request->fname;
            $a->LName=$request->lname;
            $a->email=$request->email;
            $a->Phone=$request->phone;
            $a->PostalCode=$request->postacode;
            $a->FullAddress=$request->fulladdress;
            $a->BDay=$request->bday;
            $a->RoleTypeID=1;
            $a->SexTypeID=$request->sextype;
            $a->LastLogin=Carbon::now();
            $a->DefaultPassword=0;
            $a->save();
            return redirect('/');
        }else {
            return redirect('/');
        }
    }
}
