<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\GradeType;
use App\Models\HomeWork;
use App\Models\HomeWorkStudent;
use App\Models\LatesMissing;
use App\Models\Lesson;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\VerificationType;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TeacherFunctionController extends Controller
{
    function Warnings()
    {
       
        $warnings=Warning::with("GetStudent")->where('WhoGaveID','=',Auth::user()->UserID)->get();
       
        return view('userviews/teacher/warning',['status'=>0,'warnings'=> $warnings,"ownclasses"=>self::HasClass()]);
    }
    function NewWarning()
    {
        return view('userviews/teacher/warning',['status'=>2,'students'=>Student::all(),"ownclasses"=>self::HasClass()]);
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
        return redirect('/tanar/figyelmeztetesek')->with('successmessage', "sikeres mentés");

    }

    function Lessons()
    {
        $lessonsWithdSubject=Lesson::with(["GetSubject"])->where("TeacherID","=",Auth::user()->UserID)->get();
        return view('userviews/teacher/lesson',['status'=>0,'lessons'=>$lessonsWithdSubject,"ownclasses"=>self::HasClass()]);
    }
    function LessonsClasses($lessonID) 
    {
        $lesson=Lesson::with(['GetClasses','GetSubject'])->where('ID', '=', $lessonID)->first();
        return view('userviews/teacher/lesson',['status'=>4,'classes'=>$lesson->GetClasses,"subjectName"=>$lesson->GetSubject->Name,"lessonID"=>$lessonID,"ownclasses"=>self::HasClass()]);
    }
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
        return view('userviews/teacher/rating',['status'=>4,"ownclasses"=>self::HasClass(),'gradesByStudent'=>$gradesByStudent,"classname"=>$class->Name,'subjectName'=>$lesson->GetSubject->Name,'lessonID'=>$lessonID,'classID'=>$classID]);
    }
    function  AddNewRatingToLessonClass($lessonID,$classID)
    {
        $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();


        return view('userviews/teacher/rating',['status'=>5,"ownclasses"=>self::HasClass(),'students'=>$class->GetStudents,"classname"=>$class->Name,'classID'=>$classID,'lessonID'=>$lessonID,'grades'=>GradeType::all()]);
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
        return redirect('/tanar/ertekelesek/tanora/'.$request->lessonID.'/osztaly/'.$request->classID)->with('successmessage', "sikeres mentés");
    }
    function EditStudentRatingPage($gradeID)  
    {
        $grade=Grade::GetGradeWithStudentIfExist($gradeID);
        if (!$grade) {
            return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
        }
        return view('userviews/teacher/rating',['status'=>7,"ownclasses"=>self::HasClass(),'rating'=>$grade,'grades'=>GradeType::all()]);
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
        return redirect('/tanar/tanorak')->with('successmessage', "sikeres mentés");
    }

    


    function MissingsLessons($lessonID,$classID)
    {
        $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();
        // Initialize an empty array to store grades
        $missingsByStudent = [];
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
        return view('userviews/teacher/missings',['status'=>4,"ownclasses"=>self::HasClass(),'missingsByStudent'=>$missingsByStudent,"classname"=>$class->Name,'subjectName'=>$lesson->GetSubject->Name,'lessonID'=>$lessonID,'classID'=>$classID]);
    }
    function  AddNewissingToLessonClass($lessonID,$classID)
    {
        $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();


        return view('userviews/teacher/missings',['status'=>5,"ownclasses"=>self::HasClass(),'students'=>$class->GetStudents,"classname"=>$class->Name,'classID'=>$classID,'lessonID'=>$lessonID,'verifTypes'=>VerificationType::all()]);
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
        return redirect('/teacher/hianyzasok/tanora/'.$request->lessonID.'/osztaly/'.$request->classID)->with('successmessage', "sikeres mentés");
    }

    function EditStudentMissingPage($missID)  
    {
        $miss=LatesMissing::GetMissingIfExist($missID);
        if (!$miss) {
            return redirect('/tanar/tanorak')->with('failedmessage', "ID nem található");
        }
        return view('userviews/teacher/missings',['status'=>7,"ownclasses"=>self::HasClass(),'missing'=>$miss,'VerifTypes'=>VerificationType::all()]);
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
        return redirect('/tanar/tanorak')->with('successmessage', "sikeres mentés");
    }



    function StudentsHomeWorksByLesson($lessonID)
    {
        $h=HomeWork::with(['GetLesson.GetClasses'])->where("LessonID","=",$lessonID)->get();
        return view('userviews/teacher/homework',['status'=>0,"ownclasses"=>self::HasClass(),'homeworks'=>$h,'lessonid'=>$lessonID]);
       
    }
    function StudentsHomeWorks($homewokID)
    {
        $h=HomeWork::with('GetLesson.GetClasses.GetStudents')->where("ID","=",$homewokID)->first();
        $homeworksByStudent = [];
        foreach ($h->GetLesson->GetClasses as $class) {
            foreach ( $class->GetStudents as $student) {
                $s=HomeWorkStudent::with(['GetStudent','GetHomework'])->where([
                    'HomeWorkID' => $homewokID,
                    'StudentID'=>$student->UserID
                ])->first();
                $homeworksByStudent[] = [
                    'UserID' => $student->UserID,
                    'name' => $student->LName." ".$student->FName,
                    'classname'=>$class->Name,
                    'hw' =>  $s
                ];
            }
        }
      
        return view('userviews/teacher/homework',['status'=>4,'homeworks'=>$homeworksByStudent]);
        
    }
    
    function EditHomeWorkPage($homewokID,$lessonID)  
    {
        $homework=HomeWork::GetHomeworkIfExist($homewokID);
        if (!$homework) {
            return redirect('/tanar/tanorak')->with('failedmessage', "ID nem található");
        }
        return view('userviews/teacher/homework',['status'=>3,"ownclasses"=>self::HasClass(),'homework'=>$homework,'lessonid'=>$lessonID]);
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
        return redirect('/tanar/tanorak')->with('successmessage', "sikeres mentés");
    }

    function EditHomeWorkComment(Request $request) 
    {
       try {
            if ( HomeWorkStudent::EditAnswer($request->homeworkid,$request->studentid,$request->comment)) {
                return response()->json(['status'=>0,'message' => 'Sikeres módosítás'], 200);
            }else {
                return response()->json(['status'=>1,'message' => 'Sikertelen módosítás'], 200);
            }
       } catch (\Throwable $th) {
        error_log($th);
        return response()->json(['status'=>1,'message' => 'Sikertelen módosítás, bemeneti adat hiba'], 200);
       }
       
    }

    function NewHomeWork($lessonID)
    {
        return view('userviews/teacher/homework',['status'=>2,"ownclasses"=>self::HasClass(),'lessonid'=>$lessonID]);
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
        return redirect('/tanar/tanorak')->with('successmessage', "sikeres mentés");

    }
    function RemoveStudentHomeWork($homewokID,$studentID) 
    {
        if (!HomeWorkStudent::RemoveStudentHomework($homewokID,$studentID)) {
            return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
        }
        return redirect('/tanar/tanorak')->with('successmessage', "sikeres mentés");
    }


    function HasClass() 
    {
        $classes=SchoolClass::where("ClassMasterID","=",Auth::user()->UserID)->get();
        if (!$classes) {
            return false;
        }
        if (count($classes)>0) {
            return true;
        }
        return false;
        
    }
}
