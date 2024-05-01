<?php

namespace App\Http\Controllers\admin;

use App\CustomClasses\PwHasher;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DatabaseController;
use App\Models\Admin;
use App\Models\BannedIP;
use App\Models\ClassesLessons;
use App\Models\Grade;
use App\Models\GradeType;
use App\Models\HeadUser;
use App\Models\HomeWork;
use App\Models\HomeWorkStudent;
use App\Models\LatesMissing;
use App\Models\Lesson;
use App\Models\RoleType;
use App\Models\SchoolClass;
use App\Models\SexType;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\StudentsClass;
use App\Models\StudParent;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\VerificationType;
use App\Models\Warning;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\StreamOutput;

class AdminFunctionsController extends Controller
{
    //users
        function UsersPage()
        {
            return view('userviews/admin/felh',['status'=>1]);
        }

        function NewUserPage()
        {
            return view('userviews/admin/felh',['status'=>2,'roles'=>RoleType::all(),'sextypes'=>SexType::all()]);
        }

        function EditUserPage($UserID) {
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
                    $aditionalAttrinutes = [
                        'bPlace' => $user->BPlace,
                        'studentCardNum' => $user->StudentCardNum,
                        'studentTeachID' => $user->StudentTeachID,
                        'remainingVerifications'=>$user->RemainedParentVerification
                    ];
                    break;
                case 't':
                    $user = Teacher::where([
                        'UserID' => $UserID
                    ])->first();
                    $aditionalAttrinutes = [
                        'teachID' => $user->TeachID
                    ];
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
            $additionalAttributesJson = json_encode($aditionalAttrinutes);
           
            if ($user)
            {
                return view('userviews/admin/felh',['status'=>3,'roles'=>RoleType::all(),'sextypes'=>SexType::all(),'user'=>$user,'aditionals'=>$additionalAttributesJson]);
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
                $user->Email= $request->email;
                $user->Phone=$request->phone;
                $user->SexTypeID=$request->sextype;

               
                if ((!empty($request->pw))&&$request->pw!=" ") {
                  
                    $hashedpw=PwHasher::hasheles($request->pw);
                    $user->password= $hashedpw;
                    $user->DefaultPassword= 1;
                    
                }
                try { 
                    $user->save();
                } catch (\Throwable $th) {
                    dd($th);
                    return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
                }
                return redirect('/admin/felhasznalok/'.$azonositoValaszto)->with('successmessage', "Sikeres mentés.");
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
                    return redirect('/admin/felhasznalok')->with('successmessage', $a);
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
                case 's':
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
                case 'p':
                    foreach (StudParent::all() as $user) {
                        $u=new OneUser();
                        $u->UserID=$user->UserID;
                        $u->fname=$user->FName;
                        $u->lname=$user->LName;
                        $u->role=(RoleType::where('ID',$user->RoleTypeID)->first())->Name;
                        $users[]=$u;
                    }
                    break;
                case 'h':
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
            return view('userviews/admin/felh',['status'=>0,'users'=>$users]);
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
            return view('userviews/admin/felh',['status'=>0,'users'=>$users]);
        }
    //users

    //parentstudent
        function StudParConns()
        {
            return view('userviews/admin/studparconn',['status'=>0,'conns'=>StudentParent::with(["GetStudent","GetParent"])->get()]);
        }

        function RemoveStudPar($studentID,$parentID) 
        {
            if (!StudentParent::RemoveStudPar($studentID,$parentID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/kapcsolat/szulodiak')->with('successmessage', "sikeres mentés");
        }

        function NewStudPar()
        {
            return view('userviews/admin/studparconn',['status'=>2,"parents"=>StudParent::all(),'students'=>Student::all()]);
        }

        function SaveStudPar(Request $request) 
        {
            $studentID="";
            $parentID="";
            if ($request->studentID==null) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }

            if ($request->parentID==null) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }

            $studentID=$request->studentID;
            $parentID=$request->parentID;
            if (StudentParent::GetStudParIfExist($studentID,$parentID)!=null) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen, kapcsolat már létezik.");
            }
            if (!StudentParent::AddNewStudPar($studentID,$parentID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/kapcsolat/szulodiak')->with('successmessage', "sikeres mentés");

        }
    //parentstudent

    //roles
        function Roles()
        {
            return view('userviews/admin/role',['status'=>0,'roles'=>RoleType::all()]);
        }

        function EditRolePage($roleID)  {
            $role=RoleType::GetRoleIfExist($roleID);
            if (!$role) {
                return redirect('/admin/rangok')->with('failedmessage', "ID nem található");
            }
            return view('userviews/admin/role',['status'=>3,'role'=>$role]);
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
            return redirect('/admin/rangok')->with('successmessage', "sikeres mentés");
        }

        function NewRole()
        {
            return view('userviews/admin/role',['status'=>2]);
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
            return redirect('/admin/rangok')->with('successmessage', "sikeres mentés");

        }
    //roles

    //banning
        function BannedUSers()
        {
            return view('userviews/admin/bannedUsers',['status'=>0,'users'=>BannedIP::all()->toArray()]);
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
            return view('userviews/admin/bannedUsers',['status'=>2,'roles'=>RoleType::all(),'sextypes'=>SexType::all()]);
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
            if (!BannedIP::AddNewBann($UUID,$UUIDbanned,$IP,$IPbanned)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/kitiltottak')->with('successmessage', "sikeres mentés");
        }
    //banning

    //backupAndNuke

        function BackupYearAndNukeConfirm() 
        {
            return view('userviews/admin/areyousure',['gotopage'=>"/admin/doevvege"]);
        }
        function BackupYearAndNuke() 
        {

        if(DatabaseController::EndYearBackup())
        {
            return redirect('/vezerlopult')->with('successmessage', "sikeres mentés");
        }else {
            return redirect('/vezerlopult')->with('failedmessage', "sikertelen mentés");
        }

        
        
        }
    //backupAndNuke

    //classes
        function SchoolClasses()
        {
            $classesWithTeachers=SchoolClass::with("GetTeacher")->get();
            return view('userviews/admin/school_Classes',['status'=>0,'classes'=>$classesWithTeachers]);
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

            return view('userviews/admin/school_Classes',['status'=>4,'users'=>$users,'classID'=>$classID,'className'=> $class->Name]);
        }

        function RemoveStudentFromClass($classID,$studentID) 
        {
            
            if (!StudentsClass::RemoveStudentFromClass($classID,$studentID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/osztaly/diakok/'.$classID)->with('successmessage', "sikeres mentés");
        }
        

        function AddStudentToClass($classID) 
        {
            $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();
            $studentIdsInClass = $class->GetStudents->pluck('UserID')->toArray();
            $studentsNotInClass = Student::whereNotIn('UserID', $studentIdsInClass)->get();
            return view('userviews/admin/school_Classes',['status'=>5,'students'=>$studentsNotInClass,'classID'=>$classID]);
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
            return redirect('/admin/osztalyok/diakhozzad/'.$ClassID)->with('successmessage', "sikeres mentés");
        }
        
       

        function EditClassPage($classID)  {
            $class=SchoolClass::GetCllassIfExist($classID);
            if (!$class) {
                return redirect('/admin/osztalyok')->with('failedmessage', "ID nem található");
            }
            return view('userviews/admin/school_Classes',['status'=>3,'classinfo'=>$class,'teachers'=>Teacher::query()->orderBy('FName', 'desc')->get()]);
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
            return redirect('/admin/osztalyok')->with('successmessage', "sikeres mentés");
        }

        function NewClass()
        {
            return view('userviews/admin/school_Classes',['status'=>2,'teachers'=>Teacher::query()->orderBy('FName', 'desc')->get()]);
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
            return redirect('/admin/osztalyok')->with('successmessage', "sikeres mentés");

        }
    //classes

    //subjects
        function Subjects()
        {
            return view('userviews/admin/subject',['status'=>0,'subjects'=>Subject::all()]);
        }

        function SubjectLessons($sujectID) 
        {
            $sub=Subject::with('GetLessons')->where('ID', '=', $sujectID)->first();

            return view('userviews/admin/lesson',['status'=>0,'lessons'=>$sub->GetLessons]);
        }

        function EditSubjectPage($sujectID)  {
            $subject=Subject::GetSubjectIfExist($sujectID);
            if (!$subject) {
                return redirect('/admin/tantargyak')->with('failedmessage', "ID nem található");
            }
            return view('userviews/admin/subject',['status'=>3,'subject'=>$subject]);
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
            return redirect('/admin/tantargyak')->with('successmessage', "sikeres mentés");
        }

        function NewSubject()
        {
            return view('userviews/admin/subject',['status'=>2]);
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
            return redirect('/admin/tantargyak')->with('successmessage', "sikeres mentés");

        }
    //subjects

    //lessons
        function Lessons()
        {
            $lessonsWithTeachersAndSubject=Lesson::with(["GetTeacher","GetSubject"])->get();
            return view('userviews/admin/lesson',['status'=>0,'lessons'=>$lessonsWithTeachersAndSubject]);
        }

        function LessonsClasses($lessonID) 
        {
            $lesson=Lesson::with(['GetClasses','GetSubject','GetTeacher'])->where('ID', '=', $lessonID)->first();
            return view('userviews/admin/lesson',['status'=>4,'classes'=>$lesson->GetClasses,"subjectName"=>$lesson->GetSubject->Name,"teacherName"=>($lesson->GetTeacher->FName." ".$lesson->GetTeacher->LName),"lessonID"=>$lessonID]);
        }

        function RemoveClassFromLesson($lessonID,$classID) 
        {
            if (!ClassesLessons::RemoveClassFromLesson($lessonID,$classID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/tanora/osztalyok/'.$lessonID)->with('successmessage', "sikeres mentés");
        }
        

        function AddClassToLesson($lessonID) 
        {
            $lesson=Lesson::with('GetClasses')->where('ID', '=', $lessonID)->first();
            $classIdsInLesson = $lesson->GetClasses->pluck('ID')->toArray();
            
            $classIdsNotInLesson = SchoolClass::with('GetTeacher')->whereNotIn('ID', $classIdsInLesson)->get();
            return view('userviews/admin/lesson',['status'=>5,'classes'=>$classIdsNotInLesson,'lessonID'=>$lessonID]);
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
            return redirect('/admin/osztalyok/diakhozzad/'.$classID)->with('successmessage', "sikeres mentés");
        }
        

      

        function EditLessonPage($lessonID)  {
            $lesson=Lesson::GetLessonIfExist($lessonID);
            $teachers=Teacher::query()->orderBy('FName', 'desc')->get();
            $subjects=Subject::all();
            if (!$lesson) {
                return redirect('/admin/tanorak')->with('failedmessage', "ID nem található");
            }
            return view('userviews/admin/lesson',['status'=>3,'lesson'=>$lesson,'teachers'=>$teachers,'subjects'=>$subjects]);
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
            return redirect('/admin/tanorak')->with('successmessage', "sikeres mentés");
        }

        function NewLesson()
        {
            $teachers=Teacher::query()->orderBy('FName', 'desc')->get();
            $subjects=Subject::all();

            return view('userviews/admin/lesson',['status'=>2,'teachers'=>$teachers,'subjects'=>$subjects]);
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
            return redirect('/admin/tanorak')->with('successmessage', "sikeres mentés");

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
            return view('userviews/admin/rating',['status'=>2]);
        }
        function RatingTypes()
        {
            return view('userviews/admin/rating',['status'=>0,'ratings'=>GradeType::all()]);
        }

        function EditRatinTypegPage($gradeID)  {
            $gradetype=GradeType::GetGradeIfExist($gradeID);
            if (!$gradetype) {
                return redirect('/admin/ertekelestipusok')->with('failedmessage', "ID nem található");
            }
            return view('userviews/admin/rating',['status'=>3,'rating'=>$gradetype]);
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
            return redirect('/admin/ertekelestipusok')->with('successmessage', "sikeres mentés");
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
            return redirect('/admin/ertekelestipusok')->with('successmessage', "sikeres mentés");

        }

      
    //ratingtypes

    //ratings

        function RatingsLessons($lessonID,$classID)
        {
            $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();
            // Initialize an empty array to store grades
            $gradesByStudent = [];
            $lesson=Lesson::with('GetSubject')->where('ID', $lessonID)->first();
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
            return view('userviews/admin/rating',['status'=>4,'gradesByStudent'=>$gradesByStudent,"classname"=>$class->Name,'subjectName'=>$lesson->GetSubject->Name,'lessonID'=>$lessonID,'classID'=>$classID]);
        }

        function  AddNewRatingToLessonClass($lessonID,$classID)
        {
            $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();


            return view('userviews/admin/rating',['status'=>5,'students'=>$class->GetStudents,"classname"=>$class->Name,'classID'=>$classID,'lessonID'=>$lessonID,'grades'=>GradeType::all()]);
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
            return redirect('/admin/ertekelesek/tanora/'.$request->lessonID.'/osztaly/'.$request->classID)->with('successmessage', "sikeres mentés");
        }
    
        

        function RemoveRatingType($ratingID) 
        {
            if (!GradeType::RemoveGrade($ratingID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/ertekelestipusok')->with('successmessage', "sikeres mentés");
        }


        function RecentRatings()
        {
            return view('userviews/admin/rating',['status'=>6,'ratings'=>Grade::with(['GetStudent','GetLesson.GetSubject','GetLesson.GetTeacher','GetGradeType'])->latest()->take(20)->get()]);
        }

        function RemoveStudentGrade($ratingID) 
        {
            if (!Grade::RemoveGrade($ratingID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/ertekelesek')->with('successmessage', "sikeres mentés");
        }

        function EditStudentRatingPage($gradeID)  
        {
            $grade=Grade::GetGradeWithStudentIfExist($gradeID);
            if (!$grade) {
                return redirect('/admin/ertekelesek')->with('failedmessage', "ID nem található");
            }
            return view('userviews/admin/rating',['status'=>7,'rating'=>$grade,'grades'=>GradeType::all()]);
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
            return redirect('/admin/ertekelesek')->with('successmessage', "sikeres mentés");
        }

        

    //ratings

    //verifications types
        function NewVerifType()
        {
            return view('userviews/admin/missings',['status'=>2]);
        }
        function VerifTypes()
        {
            return view('userviews/admin/missings',['status'=>0,'veriftypes'=>VerificationType::all()]);
        }

        function EditVerifTypegPage($verifID)  
        {
            $veriftype=VerificationType::GetVerifIfExist($verifID);
            if (!$veriftype) {
                return redirect('/admin/igazolastipusok')->with('failedmessage', "ID nem található");
            }
            return view('userviews/admin/missings',['status'=>3,'verif'=>$veriftype]);
        }
        function SaveVerifType(Request $request) 
        {
            $name="";
            $description="";
            if ($request->name!=null) {
            
                $name=$request->name;
            }
            if ($request->description!=null) {
                $description=$request->description;
            }
            if (!VerificationType::AddNewVerif($name,$description)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/igazolastipusok')->with('successmessage', "sikeres mentés");

        }
        function EditVerifType(Request $request) 
        {
            $name="";
            $description="";
            if ($request->name!=null) {
            
                $name=$request->name;
            }
            if ($request->description!=null) {
                $description=$request->description;
            }
            if (!VerificationType::EditVerif($request->verificationID,$name,$description)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/igazolastipusok')->with('successmessage', "sikeres mentés");
        }
    //verification types

    //lates-missings
        function RecentMissings()
        {
            return view('userviews/admin/missings',['status'=>6,'missings'=>LatesMissing::with(['GetStudent','GetLesson.GetSubject','GetLesson.GetTeacher','GetVerificationType'])->latest()->take(20)->get()]);
        }
        function RemoveStudentMissing($missID) 
        {
            if (!LatesMissing::RemoveMissing($missID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/hianyzasok')->with('successmessage', "sikeres mentés");
        }

        function EditStudentMissingPage($missID)  
        {
            $miss=LatesMissing::GetMissingIfExist($missID);
            if (!$miss) {
                return redirect('/admin/hianyzasok')->with('failedmessage', "ID nem található");
            }
            return view('userviews/admin/missings',['status'=>7,'missing'=>$miss,'VerifTypes'=>VerificationType::all()]);
        }

        function EditStudentMissing(Request $request) 
        {
            $verificatiopTypeID=null;
            $minutes=0;
            
            if ($request->verifID!=null) {
                $verificatiopTypeID=$request->verifID;
            }
            if ($request->minutes!=null) {
                $minutes=$request->minutes;
            }
            $c=LatesMissing::GetMissingIfExist($request->missID);
            if ($c->Verified==1&& $verificatiopTypeID==null) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen\n igazolást nem lehet visszavonni!");
            }
            if (!LatesMissing::EditMissing($request->missID,$minutes,$verificatiopTypeID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/hianyzasok')->with('successmessage', "sikeres mentés");
        }

        function MissingsLessons($lessonID,$classID)
        {
            $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();
            // Initialize an empty array to store grades
            $gradesByStudent = [];
            $lesson=Lesson::with('GetSubject')->where('ID', $lessonID)->first();
            // Loop through each student in the class
            foreach ($class->GetStudents as $student) {
                // Get grades for the student for the given lesson
                $missings = LatesMissing::with('GetVerificationType')->where('StudentID', $student->UserID)
                            ->where('LessonID', $lessonID)
                            ->get();
            
                // Add grades to the array grouped by StudentID
                $missingsByStudent[$student->UserID] = [
                    'UserID' => $student->UserID,
                    'name' => $student->LName." ".$student->FName,
                    'missings' => $missings
                ];
            }
            return view('userviews/admin/missings',['status'=>4,'missingsByStudent'=>$missingsByStudent,"classname"=>$class->Name,'subjectName'=>$lesson->GetSubject->Name,'lessonID'=>$lessonID,'classID'=>$classID]);
        }

        function  AddNewissingToLessonClass($lessonID,$classID)
        {
            $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();


            return view('userviews/admin/missings',['status'=>5,'students'=>$class->GetStudents,"classname"=>$class->Name,'classID'=>$classID,'lessonID'=>$lessonID,'verifTypes'=>VerificationType::all()]);
        }

        
        function SaveNewissingToLessonClass(Request $request) 
        {
            $data = $request->except(['_token','lessonID','dtBasicExample_length','classID']);
        
            
            // Initialize an empty array to store filtered student grades
            $filteredMissingVerifications = [];
            $filteredMissingMinutes = [];

            // Loop through the request parameters
            foreach ($data as $key => $value) {
                // Check if the parameter key starts with 'gradeID_'
                if (strpos($key, 'missingID_') === 0) {
                    // Extract StudentID from the parameter key
                    $studentID = substr($key, 10); // Assuming the length of 'gradeID_' is 8 characters
                    
                    // Check if the grade is not equal to -1
                    if ($value != -1) {
                        // Add StudentID and gradeTypeID to the filtered array
                        $filteredMissingVerifications[$studentID] = $value;
                    }
                }
                else if(strpos($key, 'minutes_') === 0)
                {
                    $studentID = substr($key, 8); // Assuming the length of 'gradeID_' is 8 characters
                    
                    // Check if the grade is not equal to -1
                    if ($value > 0) {
                        // Add StudentID and gradeTypeID to the filtered array
                        $filteredMissingMinutes[$studentID] = $value;
                    }
                }
            }
        
            DB::beginTransaction();
            foreach ($filteredMissingMinutes as $key => $value) {
                $misid=null;
                if ($filteredMissingVerifications) {
                    try {
                        $misid=$filteredMissingVerifications[$key];
                    } catch (\Throwable $th) {
                        $misid=null;
                    }
                }
                if ( !LatesMissing::AddNewMissingToLesson($key,$request->lessonID,$value, $misid)) {
                    DB::rollBack();
                    return redirect()->back()->with('failedmessage', "Mentés sikeretlen, módosítások visszavonva");
                }
            
            }
            DB::commit();
            return redirect('/admin/hianyzasok/tanora/'.$request->lessonID.'/osztaly/'.$request->classID)->with('successmessage', "sikeres mentés");
        }

    //lates-missings

    //warnings
        function Warnings()
        {
            $wariningswithUsers = [];

            // Loop through each student in the class
            foreach (Warning::with(['GetStudent'])->get() as $warning) {
                
                $whogave=Warning::GetWhoGave($warning->ID);
                $wariningswithUsers[$warning->ID] = [
                    'ID' => $warning->ID,
                    'name' => $warning->Name,
                    'description' => $warning->Description,
                    'datetime' => $warning->DateTime,
                    'whogavename' => $whogave->LName." ". $whogave->FName,
                    'whogaveID' => $warning->WhoGaveID,
                    'studentID'=>$warning->StudentID,
                    'studentname'=>$warning->GetStudent->LName." ". $warning->GetStudent->FName
                ];
            }
            return view('userviews/admin/warning',['status'=>0,'warnings'=>$wariningswithUsers]);
        }

        function EditWarningPage($warningID)  
        {
            $warning=Warning::GetWarningIfExist($warningID);
            if (!$warning) {
                return redirect('/admin/figyelmeztetesek')->with('failedmessage', "ID nem található");
            }
            return view('userviews/admin/warning',['status'=>3,'warning'=>$warning,'students'=>Student::all( )]);
        }

        function EditWarning(Request $request) 
        {
            $name="";
            $description="";
            $studentID="";
            if ($request->description!=null) {
                $description=$request->description;
            }
            if ($request->studentID!=null) {
                $studentID=$request->studentID;
            }
            if ($request->name!=null) {
                $name=$request->name;
            }
            if (!Warning::EditWarning($request->warningID,$name,$description,$studentID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/figyelmeztetesek')->with('successmessage', "sikeres mentés");
        }

        function NewWarning()
        {
            return view('userviews/admin/warning',['status'=>2,'students'=>Student::all()]);
        }

        function SaveWarning(Request $request) 
        {
            $name="";
            $description="";
            $studentID="";
            if ($request->description!=null) {
                $description=$request->description;
            }
            if ($request->studentID!=null) {
                $studentID=$request->studentID;
            }
            if ($request->name!=null) {
                $name=$request->name;
            }
            if (!Warning::AddNewWarning($name,$description,Auth::user()->UserID,$studentID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/figyelmeztetesek')->with('successmessage', "sikeres mentés");

        }

        function RemoveWarning($warningID) 
        {
            if (!Warning::RemoveWarning($warningID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/figyelmeztetesek')->with('successmessage', "sikeres mentés");
        }
        
    //warnings

    //homeworks
        function HomeWorks()
        {
            return view('userviews/admin/homework',['status'=>0,'homeworks'=>HomeWork::with(['GetLesson.GetTeacher','GetLesson.GetSubject','GetLesson.GetClasses'])->get()]);
        }
        function StudentsHomeWorks($homewokID)
        {

            return view('userviews/admin/homework',['status'=>4,'homeworks'=>HomeWorkStudent::with(['GetStudent','GetHomework'])->where([
                'HomeWorkID' => $homewokID
            ])->get()]);
            
        }
        function RemoveStudentHomeWork($homewokID,$studentID) 
        {
            if (!HomeWorkStudent::RemoveStudentHomework($homewokID,$studentID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/hazifeladatok')->with('successmessage', "sikeres mentés");
        }

        function DownloadHomeWork($homewokID,$studentID) 
        {
            $c=null;
            if ( !($c=HomeWorkStudent::GetHomeworkIfExist($homewokID,$studentID)) ) {
                return redirect()->back()->with('failedmessage', "Letöltés sikeretlen");
            }
            if ($c->FileName==""||$c->FileName==" "||$c->FileName==null) {
                return redirect()->back()->with('failedmessage', "Hibás fájlnév az adatbázisban.");
            }

            $folderPath = '\public\homeworks\id_'.$homewokID;
            $folderStructurePath = storage_path().'\app'. $folderPath;
    
            $file= $folderStructurePath."\\".$c->FileName;

            if ( file_exists($file)) {
                return response()->download( $file);
            }else
            {
                return redirect()->back()->with('failedmessage', "Fájl nem található");
            }
        } 

        function HomeWorkClasses($homewokID) 
        {
            $homeworks=HomeWork::with('GetLesson.GetClasses')->where([
                'ID' => $homewokID
            ])->first();
            $classes=[];
           
            foreach ($homeworks->GetLesson->GetClasses as  $class) {
                $classes[]=$class;
            }
            return view('userviews/admin/school_Classes',['status'=>0,'classes'=>$classes]);
        }
        function EditHomeWorkPage($homewokID)  
        {
            $homework=HomeWork::GetHomeworkIfExist($homewokID);
            if (!$homework) {
                return redirect('/admin/hazifeladatok')->with('failedmessage', "ID nem található");
            }
            return view('userviews/admin/homework',['status'=>3,'homework'=>$homework,'lessons'=>Lesson::with(['GetSubject','GetClasses','GetTeacher'])->get()]);
        }

        function EditHomeWork(Request $request) 
        {
            $name="";
            $description="";
            $lessonID="";
            $start=null;
            $end=null;
            $active=false;
            if ($request->description!=null) {
                $description=$request->description;
            }
            if ($request->lessonID!=null) {
                $lessonID=$request->lessonID;
            }
            if ($request->name!=null) {
                $name=$request->name;
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
            if (!HomeWork::EditHomeWork($request->homeworkID,$lessonID,$name,$description,$start,$end,$active)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/hazifeladatok')->with('successmessage', "sikeres mentés");
        }

        function NewHomeWork()
        {
            return view('userviews/admin/homework',['status'=>2,'lessons'=>Lesson::with(['GetSubject','GetClasses','GetTeacher'])->get()]);
        }

        function SaveHomeWork(Request $request) 
        {
            $name="";
            $description="";
            $lessonID="";
            $start=null;
            $end=null;
            $active=false;
            if ($request->description!=null) {
                $description=$request->description;
            }
            if ($request->lessonID!=null) {
                $lessonID=$request->lessonID;
            }
            if ($request->name!=null) {
                $name=$request->name;
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
            if (!HomeWork::AddNewHomework($lessonID,$name,$description,$start,$end,$active)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/hazifeladatok')->with('successmessage', "sikeres mentés");

        }

        function RemoveHomeWork($homewokID) 
        {
            if (!HomeWork::RemoveHomeWork($homewokID)) {
                return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
            }
            return redirect('/admin/hazifeladatok')->with('successmessage', "sikeres mentés");
        }

    //homeworks
}


class OneUser 
{
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

