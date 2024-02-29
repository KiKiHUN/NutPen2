<?php

namespace App\Http\Controllers\admin;

use App\CustomClasses\PwHasher;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BannedIP;
use App\Models\HeadUser;
use App\Models\RoleType;
use App\Models\SchoolClass;
use App\Models\SexType;
use App\Models\Student;
use App\Models\StudParent;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AdminFunctionsController extends Controller
{
    //users
        function UsersPage()
        {
            return view('admin/felh',['status'=>1]);
        }

        function NewUserPage()
        {
            return view('admin/felh',['status'=>2,'roles'=>RoleType::all(),'sextypes'=>SexType::all()]);
        }

        function EditUserPage($USerID) {
            $u=null;
            $azonositoValaszto = mb_substr($USerID, 0, 1);
            switch ($azonositoValaszto) {
                case 'a':
                    $user = Admin::where([
                        'UserID' => $USerID
                    ])->first();
                    break;
                case 's':
                    $user = Student::where([
                        'UserID' => $USerID
                    ])->first();
                    break;
                case 't':
                    $user = Teacher::where([
                        'UserID' => $USerID
                    ])->first();
                    break;
                case 'p':
                    $user = StudParent::where([
                        'UserID' => $USerID
                    ])->first();
                    break;
                case 'h':
                    $user = HeadUser::where([
                        'UserID' => $USerID
                    ])->first();
                    break;
            }
            if ($user)
            {
                return view('admin/felh',['status'=>3,'roles'=>RoleType::all(),'sextypes'=>SexType::all(),'user'=>$user]);
            }else {
                return redirect()->back()->with('failedmessage', "Azonosító nem található");
            }
        }
        
        function EditUSer(Request $request)
        {
            $user=null;
            $USerID=$request->UserID;
            $azonositoValaszto = mb_substr($USerID, 0, 1);
            switch ($azonositoValaszto) {
                case 'a':
                    $user = Admin::where([
                        'UserID' => $USerID
                    ])->first();
                    break;
                case 's':
                    $user = Student::where([
                        'UserID' => $USerID
                    ])->first();
                    break;
                case 't':
                    $user = Teacher::where([
                        'UserID' => $USerID
                    ])->first();
                    break;
                case 'p':
                    $user = StudParent::where([
                        'UserID' => $USerID
                    ])->first();
                    break;
                case 'h':
                    $user = HeadUser::where([
                        'UserID' => $USerID
                    ])->first();
                    break;
            }
            if ($user)
            {
                $user->FName = $request->fname;
                $user->LName = $request->lname;
                $user->RoleTypeID = $request->role;
                $user->Email= $request->email;
                $user->Phone=$request->phone;
                $user->SexTypeID=$request->sextype;


                if (!empty($request->pw)&&!$request->pw==" ") {
                    $hashedpw=PwHasher::hasheles($request->pw);
                    $user->password= $hashedpw;
                    
                }
                try { 
                    $user->save();
                    return redirect('/felhasznalok/'.$azonositoValaszto)->with('successmessage', "Sikeres mentés.");
                } catch (\Throwable $th) {
                    dd($th);
                    return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
                }
            }else {
                return redirect()->back()->with('failedmessage', "Azonosító nem található");
            }

           
        }

        function AddNewUser(Request $request) 
        {
        
            $f = null;
            $good = false;
            $ID = "";
            $faker = Faker::create();
            switch ($request->role) {
                case 1:
                    $f=new Admin();
                    $i = 0;
                    while (!$good) {
                        $ID = $faker->bothify('a#?#?#?#');
                        $user = Admin::where([
                            'UserID' => $ID
                        ])->first();

                        if (!$user) {
                            $good = true;
                        }
                        if ($i >= 5000) {
                            break;
                        }
                        $i += 1;
                    }
                    break;
                case 2:
                    $f=new Student();
                    $i = 0;
                    while (!$good) {
                        $ID = $faker->bothify('s#?#?#?#');
                        $user = Student::where([
                            'UserID' => $ID
                        ])->first();

                        if (!$user) {
                            $good = true;
                        }
                        if ($i >= 5000) {
                            break;
                        }
                        $i += 1;
                    }
                    break;
                case 3:
                    $f=new Teacher();
                    $i = 0;
                    while (!$good) {
                        $ID = $faker->bothify('t#?#?#?#');
                        $user = Teacher::where([
                            'UserID' => $ID
                        ])->first();

                        if (!$user) {
                            $good = true;
                        }
                        if ($i >= 5000) {
                            break;
                        }
                        $i += 1;
                    }
                    break;
                case 4:
                    $f=new StudParent();
                    $i = 0;
                    while (!$good) {
                        $ID = $faker->bothify('p#?#?#?#');
                        $user = StudParent::where([
                            'UserID' => $ID
                        ])->first();

                        if (!$user) {
                            $good = true;
                        }
                        if ($i >= 5000) {
                            break;
                        }
                        $i += 1;
                    }
                    break;
                case 5:
                    $f=new HeadUser();
                    $i = 0;
                    while (!$good) {
                        $ID = $faker->bothify('h##?#??');
                        $user = HeadUser::where([
                            'UserID' => $ID
                        ])->first();

                        if (!$user) {
                            $good = true;
                        }
                        if ($i >= 5000) {
                            break;
                        }
                        $i += 1;
                    }
                    break;
            }
        
            if ($good) {
                $hashedpw=PwHasher::hasheles($request->pw);
                try {
                    $f->FName = $request->fname;
                    $f->LName = $request->lname;
                    $f->RoleTypeID = $request->role;
                    $f->UserID= $ID;
                    $f->password= $hashedpw;
                    $f->Email= $request->email;
                    $f->Phone=$request->phone;
                    $f->SexTypeID=$request->sextype;
                    $f->LastLogin=now();
                    $f->save();
                    $a='Sikeres mentés. Azonosító: '.$ID;
                    return redirect('/felhasznalok')->with('successmessage', $a);
                } catch (\Throwable $th) {
                    dd($th);
                    return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
                }
            }
            else {
                return redirect()->back()->with('failedmessage', 'Sikertelen mentés');
            }
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
            return view('admin/felh',['status'=>0,'users'=>$users]);
        }
    //users


    //banning
        function BannedUSers()
        {
            return view('admin/bannedUsers',['status'=>0,'users'=>BannedIP::all()->toArray()]);
        }

        function EditBannings(Request $request) 
        {
            $jsonData = $request->json()->all();

            // Log each ID
            foreach ($jsonData as $item) {
                if (!BannedIP::EditFullBannIfExist($item['ID'],(int)$item['IDBanned'],(int)$item['IPBanned'])) {
                    return response()->json(['status'=>1,'message' => $item['ID'].' ID nem található'], 200);
                }
                //error_log('ID: ' . $item['ID']);
            }
            return response()->json(['status'=>0,'message' => 'Sikeres módosítás'], 200);
        }

        function NewBanning()
        {
            return view('admin/bannedUsers',['status'=>1,'roles'=>RoleType::all(),'sextypes'=>SexType::all()]);
        }

        function SaveNewBanning(Request $request) 
        {
            $IP="";
            $UUID="";
            $UUIDbanned=0;
            $IPbanned=0;
            if ($request->UUIDtext!=null) {
                $UUID=$request->UUIDtext;
            }
            if ($request->IPtext!=null) {
                $IP=$request->IPtext;
            }
            if ($request->UUIDchk!=null) {
                if ($request->UUIDchk=="on") {
                    $UUIDbanned=1;
                }else {
                    $UUIDbanned=0;
                }
            
            }
            if ($request->IPchk!=null) {
                if ($request->IPchk=="on") {
                    $IPbanned=1;
                }else {
                    $IPbanned=0;
                }
            }
            if (!BannedIP::AddNewBann($UUID,$IP,$UUIDbanned,$IPbanned)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/kitiltottak')->with('successmessage', "sikeres mentés");
        }
    //banning

    //classes
        function SchoolClasses()
        {
            $classesWithTeachers=SchoolClass::with("GetTeacher")->get();
            return view('admin/school_Classes',['status'=>0,'classes'=>$classesWithTeachers]);
        }

        function EditClassPage($classID)  {
            $class=SchoolClass::GetCllassIfExist($classID);
            if (!$class) {
                return redirect('/osztaly')->with('failedmessage', "ID nem található");
            }
            return view('admin/school_Classes',['status'=>3,'teachers'=>Teacher::query()->orderBy('FName', 'desc')->get(),'class'=>$class]);
        }

        function EditClass(Request $request) 
        {
            $name="";
            $classMasterID=0;
            if ($request->name!=null) {
                $name=$request->name;
            }
            if ($request->teacher!=null) {
                $classMasterID=$request->teacher;
            }
            if (!SchoolClass::EditClass($request->classID,$name,$classMasterID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/osztalyok')->with('successmessage', "sikeres mentés");
        }

        function NewClass()
        {
            return view('admin/school_Classes',['status'=>2,'teachers'=>Teacher::query()->orderBy('FName', 'desc')->get()]);
        }

        function SaveClass(Request $request) 
        {
            $name="";
            $classMasterID=0;
            if ($request->name!=null) {
                $name=$request->name;
            }
            if ($request->teacher!=null) {
                $classMasterID=$request->teacher;
            }
            if (!SchoolClass::AddNewClass($name,$classMasterID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/osztaly')->with('successmessage', "sikeres mentés");

        }
    //classes
}


class OneUser {
    public $USerID=0;
    public $fname;
    public $lname;
    public $role;
}
