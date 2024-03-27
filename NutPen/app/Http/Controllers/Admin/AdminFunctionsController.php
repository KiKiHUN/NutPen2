<?php

namespace App\Http\Controllers\admin;

use App\CustomClasses\PwHasher;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BannedIP;
use App\Models\ClassesLessons;
use App\Models\Grade;
use App\Models\GradeType;
use App\Models\HeadUser;
use App\Models\Lesson;
use App\Models\RoleType;
use App\Models\SchoolClass;
use App\Models\SexType;
use App\Models\Student;
use App\Models\StudentsClass;
use App\Models\StudParent;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Mockery\Matcher\Subset;

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

        function EditUserPage($UserID) {
            $u=null;
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
                return view('admin/felh',['status'=>3,'roles'=>RoleType::all(),'sextypes'=>SexType::all(),'user'=>$user]);
            }else {
                return redirect()->back()->with('failedmessage', "Azonosító nem található");
            }
        }
        
        function EditUSer(Request $request)
        {
            $user=null;
            $UserID=$request->UserID;
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
            switch ((string)$request->role) {
                case 'Admin':
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
                case 'Diák':
                    $f=new Student();
                    $i = 0;
                    while (!$good) {
                        $ID = $faker->bothify('s#?#?#?#');
                        $user = Student::where([
                            'UserID' => $ID
                        ])->first();

                        if (!$user) {
                            $f->BPlace=$request->aditional0;
                            $f->StudentCardNum=$request->aditional1;
                            $f->StudentTeachID=$request->aditional2;
                            $f->RemainedParentVerification=$request->aditional3;
                            $good = true;
                        }
                        if ($i >= 5000) {
                            break;
                        }
                        $i += 1;
                    }
                    break;
                case 'Tanár':
                    $f=new Teacher();
                    $i = 0;
                    while (!$good) {
                        $ID = $faker->bothify('t#?#?#?#');
                        $user = Teacher::where([
                            'UserID' => $ID
                        ])->first();

                        if (!$user) {
                            $f->TeachID=$request->aditional0;
                            $good = true;
                        }
                        if ($i >= 5000) {
                            break;
                        }
                        $i += 1;
                    }
                    break;
                case 'Szülő':
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
                case 'Fő ember':
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
                    $f->FName=$request->fname;
                    $f->LName=$request->lname;
                    $f->email=$request->email;
                    $f->Phone=$request->phone;
                    $f->PostalCode=$request->postalcode;
                    $f->FullAddress=$request->fulladdress;
                    $f->BDay=$request->bday;
                    $f->RoleTypeID = (RoleType::where('Name',$request->role)->first())->ID;
                    $f->UserID= $ID;
                    $f->password= $hashedpw;
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
                        $u->UserID=$user->UserID;
                        $u->fname=$user->FName;
                        $u->lname=$user->LName;
                        $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                        $users[]=$u;
                    }
                    break;
                case 'd':
                    foreach (Student::all() as $user) {
                        $u=new OneUser();
                        $u->UserID=$user->UserID;
                        $u->fname=$user->FName;
                        $u->lname=$user->LName;
                        $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                        $users[]=$u;
                    }
                    break;
                case 't':
                    foreach (Teacher::all() as $user) {
                        $u=new OneUser();
                        $u->UserID=$user->UserID;
                        $u->fname=$user->FName;
                        $u->lname=$user->LName;
                        $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                        $users[]=$u;
                    }
                    break;
                case 's':
                    foreach (StudParent::all() as $user) {
                        $u=new OneUser();
                        $u->UserID=$user->UserID;
                        $u->fname=$user->FName;
                        $u->lname=$user->LName;
                        $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                        $users[]=$u;
                    }
                    break;
                case 'f':
                    foreach (HeadUser::all() as $user) {
                        $u=new OneUser();
                        $u->UserID=$user->UserID;
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
                $u->UserID=$user->UserID;
                $u->fname=$user->FName;
                $u->lname=$user->LName;
                $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                $users[]=$u;
            }
            foreach (Student::all() as $user) {
                $u=new OneUser();
                $u->UserID=$user->UserID;
                $u->fname=$user->FName;
                $u->lname=$user->LName;
                $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                $users[]=$u;
            }
            foreach (Teacher::all() as $user) {
                $u=new OneUser();
                $u->UserID=$user->UserID;
                $u->fname=$user->FName;
                $u->lname=$user->LName;
                $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                $users[]=$u;
            }
            foreach (StudParent::all() as $user) {
                $u=new OneUser();
                $u->UserID=$user->UserID;
                $u->fname=$user->FName;
                $u->lname=$user->LName;
                $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                $users[]=$u;
            }
            foreach (HeadUser::all() as $user) {
                $u=new OneUser();
                $u->UserID=$user->UserID;
                $u->fname=$user->FName;
                $u->lname=$user->LName;
                $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                $users[]=$u;
            }
            dd($users);
            return view('admin/felh',['status'=>0,'users'=>$users]);
        }
    //users

    //roles
        function Roles()
        {
            return view('admin/role',['status'=>0,'roles'=>RoleType::all()]);
        }

        function EditRolePage($roleID)  {
            $role=RoleType::GetRoleIfExist($roleID);
            if (!$role) {
                return redirect('/rangok')->with('failedmessage', "ID nem található");
            }
            return view('admin/role',['status'=>3,'role'=>$role]);
        }

        function EditRole(Request $request) 
        {
            $name="";
            if ($request->name!=null) {
                $name=$request->name;
            }
            if (!RoleType::EditRole($request->classID,$name)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/rangok')->with('successmessage', "sikeres mentés");
        }

        function NewRole()
        {
            return view('admin/role',['status'=>2]);
        }

        function SaveRole(Request $request) 
        {
            $name="";
            if ($request->name!=null) {
                $name=$request->name;
            }
            if (!RoleType::AddNewRole($name)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/rangok')->with('successmessage', "sikeres mentés");

        }
    //roles

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

        function ClassStudents($classID) 
        {
            $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();
            $users = [];
            foreach ($class->GetStudents as $student) {
                $u=new OneUser();
                $u->UserID=$student->UserID;
                $u->fname=$student->FName;
                $u->lname=$student->LName;
                $users[]=$u;
            }

            return view('admin/school_Classes',['status'=>4,'users'=>$users,'classID'=>$classID]);
        }

        function RemoveStudentFromClass($classID,$studentID) 
        {
            
            if (!StudentsClass::RemoveStudentFromClass($classID,$studentID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/osztaly/diakok/'.$classID)->with('successmessage', "sikeres mentés");
        }
        

        function AddStudentToClass($classID) 
        {
            $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();
            $studentIdsInClass = $class->GetStudents->pluck('UserID')->toArray();
            $studentsNotInClass = Student::whereNotIn('UserID', $studentIdsInClass)->get();
            return view('admin/school_Classes',['status'=>5,'students'=>$studentsNotInClass,'classID'=>$classID]);
        }

        function SaveStudentToClass(Request $request) 
        {
            $StudentID="";
            $ClassID="";
            if ($request->studentID==null) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }

            if ($request->classID==null) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }

            $StudentID=$request->studentID;
            $ClassID=$request->classID;
            
            if (!StudentsClass::AddNewStudent($ClassID,$StudentID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/osztalyok/diakhozzad/'.$ClassID)->with('successmessage', "sikeres mentés");
        }
        
       

        function EditClassPage($classID)  {
            $class=SchoolClass::GetCllassIfExist($classID);
            if (!$class) {
                return redirect('/osztalyok')->with('failedmessage', "ID nem található");
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
            return redirect('/osztalyok')->with('successmessage', "sikeres mentés");

        }
    //classes

    //subjects
        function Subjects()
        {
            return view('admin/subject',['status'=>0,'subjects'=>Subject::all()]);
        }

        function SubjectLessons($sujectID) 
        {
            $sub=Subject::with('GetLessons')->where('ID', '=', $sujectID)->first();

            return view('admin/lesson',['status'=>0,'lessons'=>$sub->GetLessons]);
        }

        function EditSubjectPage($sujectID)  {
            $subject=Subject::GetSubjectIfExist($sujectID);
            if (!$subject) {
                return redirect('/tantargyak')->with('failedmessage', "ID nem található");
            }
            return view('admin/subject',['status'=>3,'subject'=>$subject]);
        }

        function EditSubject(Request $request) 
        {
            $name="";
            $desc="";
            if ($request->name!=null) {
                $name=$request->name;
            }
            if ($request->description!=null) {
                $desc=$request->description;
            }
            if (!Subject::EditSubject($request->subjectID,$name,$desc)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/tantargyak')->with('successmessage', "sikeres mentés");
        }

        function NewSubject()
        {
            return view('admin/subject',['status'=>2]);
        }

        function SaveSubject(Request $request) 
        {
            $name="";
            $desc="";
            if ($request->name!=null) {
                $name=$request->name;
            }
            if ($request->description!=null) {
                $desc=$request->description;
            }
            if (!Subject::AddNewSubject($name,$desc)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/tantargyak')->with('successmessage', "sikeres mentés");

        }
    //subjects

    //lessons
        function Lessons()
        {
            $lessonsWithTeachersAndSubject=Lesson::with(["GetTeacher","GetSubject"])->get();
            return view('admin/lesson',['status'=>0,'lessons'=>$lessonsWithTeachersAndSubject]);
        }

        function LessonsClasses($lessonID) 
        {
            $lesson=Lesson::with('GetClasses')->where('ID', '=', $lessonID)->first();
            return view('admin/lesson',['status'=>4,'classes'=>$lesson->GetClasses,"lessonID"=>$lessonID]);
        }

        function RemoveClassFromLesson($lessonID,$classID) 
        {
            if (!ClassesLessons::RemoveClassFromLesson($lessonID,$classID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/tanora/osztalyok/'.$lessonID)->with('successmessage', "sikeres mentés");
        }
        

        function AddClassToLesson($lessonID) 
        {
            $lesson=Lesson::with('GetClasses')->where('ID', '=', $lessonID)->first();
            $classIdsInLesson = $lesson->GetClasses->pluck('ID')->toArray();
            
            $classIdsNotInLesson = SchoolClass::with('GetTeacher')->whereNotIn('ID', $classIdsInLesson)->get();
            return view('admin/lesson',['status'=>5,'classes'=>$classIdsNotInLesson,'lessonID'=>$lessonID]);
        }

        function SaveClassToLesson(Request $request) 
        {
            $lessonID="";
            $classID="";
            if ($request->lessonID==null) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }

            if ($request->classID==null) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
           
            $lessonID=$request->lessonID;
            $classID=$request->classID;
           
            if (!ClassesLessons::AddClassToLesson($lessonID,$classID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/osztalyok/diakhozzad/'.$classID)->with('successmessage', "sikeres mentés");
        }
        

      

        function EditLessonPage($lessonID)  {
            $lesson=Lesson::GetLessonIfExist($lessonID);
            $teachers=Teacher::query()->orderBy('FName', 'desc')->get();
            $subjects=Subject::all();
            if (!$lesson) {
                return redirect('/tanorak')->with('failedmessage', "ID nem található");
            }
            return view('admin/lesson',['status'=>3,'lesson'=>$lesson,'teachers'=>$teachers,'subjects'=>$subjects]);
        }

        function EditLesson(Request $request) 
        {
            $teach=null;
            $sub=null;
            $min=null;
            $start=null;
            $end=null;
            $active=false;
           
            if (isset($request->teacher)) {
                $teach=$request->teacher;
            }else {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            if (isset($request->subject)) {
                $sub=$request->subject;
            }else {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            if (isset($request->Minutes)) {
                $min=$request->Minutes;
            }else {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            if (isset($request->startDate)) {
                $start=$request->startDate;
            }else {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            if (isset($request->endDate)) {
                $end=$request->endDate;
            }else {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            if (isset($request->activated)) {
                $active=$request->activated;
            }
            
            $timetable = [];

            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            // Loop through each day
            foreach ($days as $day) {
                // Check if the request has corresponding CHK_ parameter
                if (isset($request["CHK_" . $day])) {
                    // If it has, assign the time to the corresponding day
                    $timetable[$day] = $request["TM_" . $day];
                } else {
                    // If it doesn't, assign null
                    $timetable[$day] = null;
                }
            }

            if (!Lesson::EditLesson($request->lessonID,intval($sub),$start,$end,intval($min),$timetable,$teach,$active)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/tanorak')->with('successmessage', "sikeres mentés");
        }

        function NewLesson()
        {
            $teachers=Teacher::query()->orderBy('FName', 'desc')->get();
            $subjects=Subject::all();

            return view('admin/lesson',['status'=>2,'teachers'=>$teachers,'subjects'=>$subjects]);
        }

        function SaveLesson(Request $request) 
        {
            $teach=null;
            $sub=null;
            $min=null;
            $start=null;
            $end=null;
            $active=false;
           
            if (isset($request->teacher)) {
                $teach=$request->teacher;
            }else {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            if (isset($request->subject)) {
                $sub=$request->subject;
            }else {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            if (isset($request->Minutes)) {
                $min=$request->Minutes;
            }else {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            if (isset($request->startDate)) {
                $start=$request->startDate;
            }else {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            if (isset($request->endDate)) {
                $end=$request->endDate;
            }else {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            if (isset($request->activated)) {
                $active=true;
            }
            
            $timetable = [];

            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            // Loop through each day
            foreach ($days as $day) {
                // Check if the request has corresponding CHK_ parameter
                if (isset($request["CHK_" . $day])) {
                    // If it has, assign the time to the corresponding day
                    $timetable[$day] = $request["TM_" . $day];
                } else {
                    // If it doesn't, assign null
                    $timetable[$day] = null;
                }
            }

            if (!Lesson::AddNewLesson(intval($sub),$start,$end,intval($min),$timetable,$teach,$active)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/tanorak')->with('successmessage', "sikeres mentés");

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
        
            return view('calendar',['status'=>0,'eventsData'=> $events]);
        }
    //lessons

    //ratingtypes

        function NewRatingType()
        {
            return view('admin/rating',['status'=>2]);
        }
        function RatingTypes()
        {
            return view('admin/rating',['status'=>0,'ratings'=>GradeType::all()]);
        }

        function EditRatinTypegPage($gradeID)  {
            $gradetype=GradeType::GetGradeIfExist($gradeID);
            if (!$gradetype) {
                return redirect('/ertekelestipusok')->with('failedmessage', "ID nem található");
            }
            return view('admin/rating',['status'=>3,'rating'=>$gradetype]);
        }

        function EditRatingType(Request $request) 
        {
            $name="";
            $value="";
            if ($request->name!=null) {
             
                $name=$request->name;
            }
            if ($request->value!=null) {
                $value=$request->value;
            }
            if (!GradeType::EditGrade($request->ratingID,$name,$value)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/ertekelestipusok')->with('successmessage', "sikeres mentés");
        }

      
    //ratingtypes

    //ratings

        function RatingsLessons($lessonID,$classID)
        {
            $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();
            // Initialize an empty array to store grades
            $gradesByStudent = [];

            // Loop through each student in the class
            foreach ($class->GetStudents as $student) {
                // Get grades for the student for the given lesson
                $grades = Grade::with('GetGradeType')->where('StudentID', $student->UserID)
                            ->where('LessonID', $lessonID)
                            ->get();
                
                // Add grades to the array grouped by StudentID
                $gradesByStudent[$student->UserID] = [
                    'UserID' => $student->UserID,
                    'name' => $student->LName." ".$student->FName,
                    'grades' => $grades
                ];
            }
            return view('admin/rating',['status'=>4,'gradesByStudent'=>$gradesByStudent,"classname"=>$class->Name,'lessonID'=>$lessonID,'classID'=>$classID]);
        }

        function  AddNewRatingToLessonClass($lessonID,$classID)
        {
            $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();


            return view('admin/rating',['status'=>5,'students'=>$class->GetStudents,"classname"=>$class->Name,'classID'=>$classID,'lessonID'=>$lessonID,'grades'=>GradeType::all()]);
        }

        
        function SaveNewRatingToLessonClass(Request $request) 
        {
            $data = $request->except(['_token','lessonID','dtBasicExample_length','classID']);
        
            
            // Initialize an empty array to store filtered student grades
            $filteredGrades = [];

            // Loop through the request parameters
            foreach ($data as $key => $value) {
                // Check if the parameter key starts with 'gradeID_'
                if (strpos($key, 'gradeID_') === 0) {
                    // Extract StudentID from the parameter key
                    $studentID = substr($key, 8); // Assuming the length of 'gradeID_' is 8 characters
                    
                    // Check if the grade is not equal to -1
                    if ($value != -1) {
                        // Add StudentID and gradeTypeID to the filtered array
                        $filteredGrades[$studentID] = $value;
                    }
                }
            }
            DB::beginTransaction();
            foreach ($filteredGrades as $key => $value) {
                if ( !Grade::AddNewGradeToLesson($key,$request->lessonID,$value)) {
                    DB::rollBack();
                    return redirect()->back()->with('failedmessage', "Mentés sikeretlen, módosítások visszavonva");
                }
            }
            DB::commit();
            return redirect('/ertekelesek/tanora/'.$request->lessonID.'/osztaly/'.$request->classID)->with('successmessage', "sikeres mentés");
        }
    
        function SaveRatingType(Request $request) 
        {
            $name="";
            $value="";
            if ($request->name!=null) {
            
                $name=$request->name;
            }
            if ($request->value!=null) {
                $value=$request->value;
            }
            if (!GradeType::AddNewGrade($name,$value)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/ertekelestipusok')->with('successmessage', "sikeres mentés");

        }

        function RemoveRatingType($ratingID) 
        {
            if (!GradeType::RemoveGrade($ratingID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/ertekelestipusok')->with('successmessage', "sikeres mentés");
        }


        function RecentRatings()
        {
            return view('admin/rating',['status'=>7,'ratings'=>Grade::with(['GetStudent','GetLesson','GetGradeType'])->latest()->take(20)->get()]);
        }

        function RemoveStudentGrade($ratingID) 
        {
            if (!Grade::RemoveGrade($ratingID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/ertekelesek')->with('successmessage', "sikeres mentés");
        }

        function EditStudentRatingPage($gradeID)  
        {
            $grade=Grade::GetGradeWithStudentIfExist($gradeID);
            if (!$grade) {
                return redirect('/ertekelesek')->with('failedmessage', "ID nem található");
            }
            return view('admin/rating',['status'=>6,'rating'=>$grade,'grades'=>GradeType::all()]);
        }

        function EditStudentRating(Request $request) 
        {
            $gradeTypeID="";
            if ($request->gradeTypeID!=null) {
                $gradeTypeID=$request->gradeTypeID;
            }
            if (!Grade::EditGrade($request->ratingID,$gradeTypeID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/ertekelesek')->with('successmessage', "sikeres mentés");
        }

    //ratings
}


class OneUser {
    public $UserID=0;
    public $fname;
    public $lname;
    public $role;
}

class CalendarData
{
    public $start="";
    public $end="";
    public $title=null;
    public $content=null;
    public $category=null;
}

