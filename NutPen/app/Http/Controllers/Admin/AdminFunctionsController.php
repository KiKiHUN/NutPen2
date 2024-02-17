<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\HeadUser;
use App\Models\RoleType;
use App\Models\Student;
use App\Models\StudParent;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AdminFunctionsController extends Controller
{
    function UsersPage()
    {
        return view('admin/felh',['status'=>2]);
    }
    function NewUserPage()
    {
        return view('admin/felh',['status'=>1,'roles'=>RoleType::all()]);
    }

    function UsersPageFilter($filter)
    {
        $users = [];
        switch ($filter) {
            case 'a':
                foreach (Admin::all() as $user) {
                    $u=new OneUser();
                    $u->USerID=$user->UserID;
                    $u->fname=$user->FName;
                    $u->lname=$user->LName;
                    $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                    $users[]=$u;
                }
                break;
            case 's':
                foreach (Student::all() as $user) {
                    $u=new OneUser();
                    $u->USerID=$user->UserID;
                    $u->fname=$user->FName;
                    $u->lname=$user->LName;
                    $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                    $users[]=$u;
                }
                break;
            case 't':
                foreach (Teacher::all() as $user) {
                    $u=new OneUser();
                    $u->USerID=$user->UserID;
                    $u->fname=$user->FName;
                    $u->lname=$user->LName;
                    $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                    $users[]=$u;
                }
                break;
            case 'p':
                foreach (StudParent::all() as $user) {
                    $u=new OneUser();
                    $u->USerID=$user->UserID;
                    $u->fname=$user->FName;
                    $u->lname=$user->LName;
                    $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                    $users[]=$u;
                }
                break;
            case 'h':
                foreach (HeadUser::all() as $user) {
                    $u=new OneUser();
                    $u->USerID=$user->UserID;
                    $u->fname=$user->FName;
                    $u->lname=$user->LName;
                    $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                    $users[]=$u;
                }
                break;
        }
        return view('admin/felh',['status'=>0,'users'=>$users]);
    }
    function allUsersPage() 
    {
        $users = [];
        foreach (Admin::all() as $user) {
            $u=new OneUser();
            $u->USerID=$user->UserID;
            $u->fname=$user->FName;
            $u->lname=$user->LName;
            $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
            $users[]=$u;
        }
        foreach (Student::all() as $user) {
            $u=new OneUser();
            $u->USerID=$user->UserID;
            $u->fname=$user->FName;
            $u->lname=$user->LName;
            $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
            $users[]=$u;
        }
        foreach (Teacher::all() as $user) {
            $u=new OneUser();
            $u->USerID=$user->UserID;
            $u->fname=$user->FName;
            $u->lname=$user->LName;
            $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
            $users[]=$u;
        }
        foreach (StudParent::all() as $user) {
            $u=new OneUser();
            $u->USerID=$user->UserID;
            $u->fname=$user->FName;
            $u->lname=$user->LName;
            $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
            $users[]=$u;
        }
        foreach (HeadUser::all() as $user) {
            $u=new OneUser();
            $u->USerID=$user->UserID;
            $u->fname=$user->FName;
            $u->lname=$user->LName;
            $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
            $users[]=$u;
        }
        dd($users);
        return view('admin/felh',['Users'=>$users]);
    }

}
class OneUser {
    public $USerID=0;
    public $fname;
    public $lname;
    public $role;
}
