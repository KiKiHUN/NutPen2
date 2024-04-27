<?php

namespace App\Http\Controllers\StudParent;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\HomeWorkStudent;
use App\Models\LatesMissing;
use App\Models\Lesson;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\StudentsClass;
use App\Models\Warning;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudParentController extends Controller
{
    

    function Students() 
    {
        return view('userviews/parent/students',['status'=>0,'students'=>StudentParent::with("GetStudent")->where("ParentID","=",Auth::user()->UserID)->get()]);
    }

   
   
    function Warnings($studID)
    {
        $warnings=Warning::where('StudentID','=',$studID)->get();
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
        return view('userviews/parent/warning',['status'=>0,'warnings'=>$wariningswithUsers,"student"=>Student::where("UserID","=",$studID)->first()]);
    }
    function Lessons($studID)
    {
        $classConnections=StudentsClass::with(['GetClass.GetLessons.GetSubject','GetClass.GetLessons.GetTeacher'])->where('StudentID','=', $studID)->get();
       
        return view('userviews/parent/lesson',['status'=>0,'lessonclassconecttions'=>$classConnections,"student"=>Student::where("UserID","=",$studID)->first()]);
    }
    function Missings($studID)
    {
        return view('userviews/parent/missings',['status'=>0,'missings'=>LatesMissing::with(['GetStudent','GetLesson.GetSubject','GetLesson.GetTeacher','GetVerificationType'])->where("StudentID","=",$studID)->latest()->get(),"student"=>Student::where("UserID","=",$studID)->first()]);
    }
    function EditMissings($missID) 
    {
        DB::beginTransaction();
        if (!LatesMissing::ParentEditMissing($missID)) {
            DB::rollBack();
            return redirect()->back()->with('failedmessage', "Mentés sikeretlen");
        }
        DB::commit();
        return redirect('/admin/hianyzasok')->with('successmessage', "sikeres mentés");
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
    function Ratings($studID)
    {
        $grades = Grade::with(['GetLesson.GetSubject','GetLesson.GetTeacher','GetGradeType'])->where('StudentID', '=', $studID)
        ->orderBy('DateTime', 'asc')
        ->get()
        ->groupBy('LessonID');
        $groupedGrades = [];

        foreach ($grades as $grade => $lessonGrades) {
            $latestGradeDateTime = $lessonGrades->last()->DateTime;
            $subjectName = $lessonGrades->last()->GetLesson->GetSubject->Name;
            $teacherName = $lessonGrades->last()->GetLesson->GetTeacher->LName." ".$lessonGrades->last()->GetLesson->GetTeacher->FName;
            $gradesArray = [];
            foreach ($lessonGrades as $grade) {
                $gradeTypeValue = $grade->GetGradeType->Value;
                $gradeTypeName = $grade->GetGradeType->Name;
                $gradeDateTime = $grade->DateTime;
                
                $gradesArray[] = [
                    'gradeValue' => $gradeTypeValue,
                    'gradeName' => $gradeTypeName,
                    'gradeDateTime' => $gradeDateTime
                ];
            }
            $groupedGrades[] = [
                'subjectName' => $subjectName,
                'latestGrade' => $latestGradeDateTime,
                'teacherName' => $teacherName,
                'grades' => $gradesArray
            ];
        }
       
        return view('userviews/parent/rating',['status'=>4,'combinedGrades'=>$groupedGrades,"student"=>Student::where("UserID","=",$studID)->first()]);
    }
    function HomeWorks($studID)
    {
       
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $currentYearStart = $currentDate->copy()->month(9)->day(1);
        if ($currentDate->lt($currentYearStart)) {
            $currentYearStart->subYear();
        }
        
        // End at July 1st of the current year
        $nextYearJuly = Carbon::create($currentYear, 7, 1, 0, 0, 0);
      

        $homeworksConnections = StudentsClass::with(
            [
                'GetClass.GetLessons.GetHomeworks'=> 
                        function ($q) use ($currentYearStart,$nextYearJuly) 
                        {
                                $q ->whereBetween('StartDateTime', [$currentYearStart, $nextYearJuly]);
                        }, 
                'GetClass.GetLessons.GetHomeworks.GetSubmittedHomeWorks',
                'GetClass.GetLessons.GetSubject',
                'GetClass.GetLessons.GetTeacher'
            ])
        ->where('StudentID', '=', $studID)
        ->get();
   

        
        $a= json_decode(json_encode($homeworksConnections), FALSE);
        return view('userviews/parent/homework',['status'=>0,'combinedHomeWorks'=> $a,"student"=>Student::where("UserID","=",$studID)->first()]);
    }
    
    function DownloadHomeWork($homewokID,$studID)
    {
       
        $c=null;
        if ( !($c=HomeWorkStudent::GetHomeworkIfExist($homewokID,$studID)) ) {
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
}
class CalendarData
{
    public $start="";
    public $end="";
    public $title=null;
    public $content=null;
    public $category=null;
}
