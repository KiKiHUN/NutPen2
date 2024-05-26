<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\HomeWork;
use App\Models\HomeWorkStudent;
use App\Models\LatesMissing;
use App\Models\Lesson;
use App\Models\RoleType;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentsClass;
use App\Models\Warning;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class StudentFunctionsController extends Controller
{
   
    function SchoolClasseWithStudents() 
    {
       
        $classConnections=StudentsClass::with('GetClass')->where('StudentID','=', Auth::user()->UserID)->get();
        return view('userviews/student/school_Classes',['status'=>0,'classes'=>$classConnections]);
    }
    function ClassStudents($classID) 
    {
        $class=SchoolClass::with('GetStudents')->where('ID', '=', $classID)->first();
        return view('userviews/student/school_Classes',['status'=>4,'class'=>$class]);
    }
    function Warnings()
    {
        $warnings=Warning::where('StudentID','=',Auth::user()->UserID)->get();
        $wariningswithUsers = [];

        // Loop through each student in the class
        foreach ($warnings as $warning) {
            
            $whogave=Warning::GetWhoGave($warning->ID);
            $wariningswithUsers[$warning->ID] = [
                    'ID' => $warning->ID,
                    'name' => $warning->Name,
                    'description' => $warning->Description,
                    'datetime'=>$warning->DateTime,
                    'whogavename' => $whogave->LName." ". $whogave->FName,
                    'whogaveID' => $warning->WhoGaveID
            ];
        }
        return view('userviews/student/warning',['status'=>0,'warnings'=>$wariningswithUsers]);
    }
    function Lessons()
    {
        $classConnections=StudentsClass::with(['GetClass.GetLessons.GetSubject','GetClass.GetLessons.GetTeacher'])->where('StudentID','=', Auth::user()->UserID)->get();
       
        return view('userviews/student/lesson',['status'=>0,'lessonclassconecttions'=>$classConnections]);
    }
    function Subjects()
    {
        $classConnections=StudentsClass::with(['GetClass.GetLessons.GetSubject'])->where('StudentID','=', Auth::user()->UserID)->get();
       
        return view('userviews/student/subject',['status'=>0,'lessonclassconecttions'=>$classConnections]);
    }
    function SubjectLessons($sujectID) 
    { 
        $classConnections = StudentsClass::with(['GetClass.GetLessons.GetSubject', 'GetClass.GetLessons.GetTeacher'])
        ->where('StudentID', '=', Auth::user()->UserID)
        ->get();
    
       
       
        $classConnections = $classConnections->filter(function ($classConnection) use ($sujectID) {
            foreach ($classConnection->GetClass->GetLessons as $lesson) {
              
                if ($lesson->SubjectID == $sujectID) {
                    return true;
                }
            }
            return false;
        });
    
        dd($classConnections);


        return view('userviews/student/lesson',['status'=>0,'lessonclassconecttions'=>$classConnections]);
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

  
    function OwnRatings()
    {
        $grades = Grade::with(['GetLesson.GetSubject','GetLesson.GetTeacher','GetGradeType'])->where('StudentID', '=', Auth::user()->UserID)
        ->orderBy('DateTime', 'asc')
        ->get()
        ->groupBy('LessonID');
        $groupedGrades = [];

        foreach ($grades as $grade => $lessonGrades) {
            $latestGradeDateTime = $lessonGrades->last()->DateTime;
            $subjectName = $lessonGrades->last()->GetLesson->GetSubject->Name;
            $teacherName = $lessonGrades->last()->GetLesson->GetTeacher->FName." ".$lessonGrades->last()->GetLesson->GetTeacher->LName;
            $gradesArray = [];
            $avg=0;
            foreach ($lessonGrades as $grade) {
                $gradeTypeValue = $grade->GetGradeType->Value;
                $gradeTypeName = $grade->GetGradeType->Name;
                $gradeDateTime = $grade->DateTime;
                
                $gradesArray[] = [
                    'gradeValue' => $gradeTypeValue,
                    'gradeName' => $gradeTypeName,
                    'gradeDateTime' => $gradeDateTime
                ];
                $avg+=$grade->GetGradeType->Value;
            }
            $avg=$avg/count($lessonGrades);
            $groupedGrades[] = [
                'subjectName' => $subjectName,
                'latestGrade' => $latestGradeDateTime,
                'teacherName' => $teacherName,
                'grades' => $gradesArray,
                'gradeavg'=>$avg
            ];
        }
      
        return view('userviews/student/rating',['status'=>4,'combinedGrades'=>$groupedGrades]);
    }
    function HomeWorks()
    {
      
      
      
      

        $homeworksConnections = StudentsClass::with(
            [
                'GetClass.GetLessons.GetHomeworks'=> 
                        function ($q)
                        {
                                $q ->where('Active','=',1);
                        }, 
                'GetClass.GetLessons.GetHomeworks.GetSubmittedHomeWorks',
                'GetClass.GetLessons.GetSubject',
                'GetClass.GetLessons.GetTeacher'
            ])
        ->where('StudentID', '=', Auth::user()->UserID)
        ->get();
   

    
    
       
        
        
        $a= json_decode(json_encode($homeworksConnections), FALSE);
        return view('userviews/student/homework',['status'=>0,'combinedHomeWorks'=> $a]);
    }
    function UploadHomeWork(Request $request)  
    {

        if(!HomeWork::GetHomeworkIfExist($request->homeworkID))
        {
            return redirect()->back()->with('failedmessage', "Sikertelen mentés, feladat ID nem található");
        }
        $sentHomewrok=null;
        $finalname=null;
        $filechanged=false;
        if (($sentHomewrok=HomeWorkStudent::GetHomeworkIfExist($request->homeworkID,Auth::user()->UserID))) {
             return redirect()->back()->with('failedmessage', "Sikertelen mentés, Egyszer már be lett adva a feladat");
        }

        if (isset($request->file_upload)) {
           
            $request->validate([
                //'file_upload' => 'required|mimes:pdf,jpg,png,txt|max:8192',
                'file_upload' => 'max:8192',
            ],
            [
                'file_upload.max' => 'A feltöltendő fájl mérete legfeljebb 8MB lehet.',
            ]);
            
          
           
            $folderPath = '\public\homeworks\id_'.$request->homeworkID;
            $folderStructurePath = storage_path().'\app'. $folderPath;

            if (! File::exists($folderStructurePath)) {
                if (!File::makeDirectory($folderStructurePath,0755,true)) {
                    return redirect()->back()->with('failedmessage', "Sikertelen mentés, szerver IO hiba");
                }
            }
            
            // Store the file in storage\app\public folder
            $file = $request->file('file_upload');
            $fileDetails=pathinfo($file->getClientOriginalName());
            
            $guessExtension = $file->guessExtension();
          
            $finalname=Auth::user()->UserID."_".$fileDetails["filename"].date('Ymd_His').".";
            
            if ( $guessExtension!=null) {
                $finalname=$finalname.$guessExtension;
            }else
            {
                $finalname=$finalname.$fileDetails["extension"];
            }
           try 
           {
            $filePath = $file->storeAs($folderPath,  $finalname );
            $filechanged=true;
           } catch (\Throwable $th) 
           {
            return redirect()->back()->with('failedmessage', "Sikertelen mentés, szerver IO hiba");
           }
           



        }
       if ( !$sentHomewrok) {
            $f=null;
            if ($filechanged) {
            $f=$finalname;
            }
            if (!HomeWorkStudent::AddNewHomework($request->homeworkID,Auth::user()->UserID,1,$f,Carbon::now(),null)) {
                return redirect()->back()->with('failedmessage', "Sikertelen mentés");
            }
       
       }
       return redirect()->back()->with('successmessage', "Sikeres mentés");
    }
    function DownloadHomeWork($homewokID)
    {
       
        $c=null;
        if ( !($c=HomeWorkStudent::GetHomeworkIfExist($homewokID,Auth::user()->UserID)) ) {
            return redirect()->back()->with('failedmessage', "Letöltés sikeretlen");
        }
        if ($c->FileName==""||$c->FileName==" "||$c->FileName==null) {
            return redirect()->back()->with('failedmessage', "Hibás fájlnév az adatbázisban.");
        }

        $folderPath = '\public\homeworks\id_'.$homewokID;
        $folderStructurePath = storage_path().'\app'. $folderPath;

        $file= $folderStructurePath."\\".$c->FileName;
       
      

        if ( file_exists($file)) {
            return response()->download($file);
        }else
        {
            return redirect()->back()->with('failedmessage', "Fájl nem található");
        }
        
    }
    function Missings()
    {
        return view('userviews/student/missings',['status'=>0,'missings'=>LatesMissing::with(['GetStudent','GetLesson.GetSubject','GetLesson.GetTeacher','GetVerificationType'])->where("StudentID","=",Auth::user()->UserID)->latest()->get(),"student"=>Student::where("UserID","=",Auth::user()->UserID)->first()]);
    }
}

class CalendarData
{
    public $start="";
    public $end="";
    public $title=null;
    public $content=null;
    public $category=null;
}