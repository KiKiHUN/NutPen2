<?php

use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['blockIP'])->group(function () {

    Route::get('/', function () {
        if (DatabaseController::IsFirstRun()) {
          return redirect("/firstrunregister");
        }
        return redirect('/login');
    });

    Route::get('/firstrunregister',[App\Http\Controllers\Auth\RegisterController::class,'SetupPage']);
    Route::post('/registeradmin',[App\Http\Controllers\Auth\RegisterController::class,'RegisterAdmin']);

    Route::get('/login',[App\Http\Controllers\Auth\LoginController::class,'LoginCall'])->name('login');
    Route::get('/GetLoginBanner',[App\Http\Controllers\MessageController::class,'GetLoginBannerMessage']);

    Route::post('/loginCheck',[App\Http\Controllers\Auth\LoginController::class,'LoginAttempt']);


    Route::group(['middleware' => 'auth:admin,headUser,teacher,student,studparent'], function () {
        Route::get('/vezerlopult',[App\Http\Controllers\MainRouterController::class,'Dash']);
        Route::get('/fiok',[App\Http\Controllers\MainRouterController::class,'Profile']);

        Route::post('/savemsg',[App\Http\Controllers\MessageController::class,'Savemsg']);
        Route::post('/newmsg',[App\Http\Controllers\MessageController::class,'Savemsg']);
        
        Route::get('/jelszoVisszaallitas',[App\Http\Controllers\MainRouterController::class,'PWResetPage']);
        Route::post('/jelszoVisszaallitas/save',[App\Http\Controllers\PWResetController::class,'SavePW']);
        Route::get('/kijelentkezes',[App\Http\Controllers\LogoutController::class,'logout']);
    });

 

    Route::group(['middleware' => 'auth:admin'], function () {
        //felhasznalo
        Route::get('/admin/felhasznalok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'UsersPage']);
        Route::get('/admin/felhasznalok/{filter}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'UsersPageFilter']);
        Route::get('/admin/ujfelhasznalo',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewUserPage']);
        Route::get('/admin/felhasznalomodositas/{UserID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditUserPage']);
        Route::post('/admin/felhasznalomodositas/mentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditUser']);
        Route::post('/admin/ujfelhasznalomentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'AddNewUser']);

        //rang
        Route::get('/admin/rangok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Roles']);
        Route::get('/admin/ujrang',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewRole']);
        Route::get('/admin/rangmodositas/{rangID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditRolePage']);
        Route::post('/admin/ujrangmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveRole']);
        Route::post('/admin/rangmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditRole']);
        

        //bannolás
        Route::get('/admin/kitiltottak',[App\Http\Controllers\Admin\AdminFunctionsController::class,'BannedUSers']);
        Route::get('/admin/ujkitiltas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewBanning']);
        Route::post('/admin/ujkitiltasmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveNewBanning']);
        Route::post('/admin/kitiltasmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditBannings']);


        //osztályok
        Route::get('/admin/osztalyok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SchoolClasses']);
        Route::get('/admin/osztaly/diakok/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'ClassStudents']);
        Route::get('/admin/ujosztaly',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewClass']);
        Route::get('/admin/osztalymodositas/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditClassPage']);
        Route::post('/admin/ujosztalymentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveClass']);
        Route::post('/admin/osztalymodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditClass']);
        Route::get('/admin/osztalyok/diakhozzad/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'AddStudentToClass']);
        Route::post('/admin/osztalyok/diakhozzad/mentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveStudentToClass']);
        Route::get('/admin/osztaly/{classID}/diaktorles/{studentID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveStudentFromClass']);

        //tantárgyak
        Route::get('/admin/tantargyak',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Subjects']);
        Route::get('/admin/tantargy/orak/{tantargyid}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SubjectLessons']);

        Route::get('/admin/ujtantargy',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewSubject']);
        Route::get('/admin/tantargymodositas/{tantargyid}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditSubjectPage']);
        Route::post('/admin/ujtantargymentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveSubject']);
        Route::post('/admin/tantargymodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditSubject']);

        //tanorak
        Route::get('/admin/tanorak',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Lessons']);
        Route::get('/admin/osztalyok/tanora/{tanoraid}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'LessonsClasses']);
        Route::get('/admin/ujtanora',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewLesson']);
        Route::get('/admin/tanoramodositas/{tanoraid}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditLessonPage']);
        Route::post('/admin/ujtanoramentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveLesson']);
        Route::post('/admin/tanoramodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditLesson']);
        Route::get('/admin/naptar/tanorak/{tanoraid}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'CalendarLesson']);
        Route::get('/admin/tanorak/osztalyhozzad/{lessonID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'AddClassToLesson']);
        Route::post('/admin/tanorak/osztalyhozzad/mentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveClassToLesson']);
        Route::get('/admin/tanora/{lessonID}/osztalytorles/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveClassFromLesson']);

        
       


         //ertekelesek
        Route::get('/admin/ertekelestipusok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RatingTypes']);
        Route::get('/admin/ujertekelestipus',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewRatingType']);
        Route::get('/admin/ertekelestipusmodositas/{gradeID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditRatinTypegPage']);
        Route::get('/admin/ertekelestipustorles/{gradeID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveRatingType']);
        Route::post('/admin/ujertekelestipusmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveRatingType']);
        Route::post('/admin/ertekelestipusmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditRatingType']);
        Route::get('/admin/ertekelesek/tanora/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RatingsLessons']);
        Route::get('/admin/tanorak/ujertekeles/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'AddNewRatingToLessonClass']);
        Route::post('/admin/tanorak/ertekelesekmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveNewRatingToLessonClass']);
        Route::get('/admin/ertekelesek',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RecentRatings']);
        Route::get('/admin/ertekelesmodositas/{gradeID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditStudentRatingPage']);
        Route::get('/admin/ertekelestorles/{gradeID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveStudentGrade']);
        Route::post('/admin/ertekelesmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditStudentRating']);

        //figyelmeztetések
        Route::get('/admin/figyelmeztetesek',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Warnings']);
        Route::get('/admin/ujfigyelmeztetes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewWarning']);
        Route::get('/admin/figyelmeztetesmodositas/{warningID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditWarningPage']);
        Route::post('/admin/ujfigyelmeztetesmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveWarning']);
        Route::post('/admin/figyelmeztetesmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditWarning']);
        Route::get('/admin/figyelmeztetestorles/{warningID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveWarning']);

        //házifeladatok
        Route::get('/admin/hazifeladatok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'HomeWorks']);
        Route::get('/admin/hazifeladatok/diakok/{homewokID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'StudentsHomeWorks']);
        Route::get('/admin/hazifeladat/osztalyok/{homewokID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'HomeWorkClasses']);
        Route::get('/admin/ujhazifeladat',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewHomeWork']);
        Route::get('/admin/hazifeladatmodositas/{homewokID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditHomeWorkPage']);
        Route::post('/admin/ujhazifeladatmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveHomeWork']);
        Route::post('/admin/hazifeladatmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditHomeWork']);
        Route::get('/admin/hazifeladattorles/{homewokID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveHomeWork']);
        Route::get('/admin/bekuldotthazifeladat/letoltes/{homewokID}/{studentID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'DownloadHomeWork']);
        Route::get('/admin/bekuldotthazifeladat/torles/{homewokID}/{studentID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveStudentHomeWork']);
    });
   
    Route::group(['middleware' => 'auth:student'], function () {
            Route::get('/diak/ertekelesek',[App\Http\Controllers\Student\StudentFunctionsController::class,'OwnRatings']);
            Route::get('/diak/hazifeladatok',[App\Http\Controllers\Student\StudentFunctionsController::class,'HomeWorks']);
            Route::get('/diak/figyelmeztetesek',[App\Http\Controllers\Student\StudentFunctionsController::class,'Warnings']);
            Route::get('/diak/tanorak',[App\Http\Controllers\Student\StudentFunctionsController::class,'Lessons']);
            Route::get('/diak/tantargyak',[App\Http\Controllers\Student\StudentFunctionsController::class,'Subjects']);
            Route::get('/diak/osztaly',[App\Http\Controllers\Student\StudentFunctionsController::class,'SchoolClasseWithStudents']);
            Route::get('/diak/osztaly/osztalytarsak/{classID}',[App\Http\Controllers\Student\StudentFunctionsController::class,'ClassStudents']);
            Route::get('/diak/naptar/tanorak/{tanoraid}',[App\Http\Controllers\Student\StudentFunctionsController::class,'CalendarLesson']);
            Route::get('/diak/tantargy/orak/{tantargyid}',[App\Http\Controllers\Student\StudentFunctionsController::class,'SubjectLessons']);
            Route::post('/diak/hazifeladat/feltoltes',[App\Http\Controllers\Student\StudentFunctionsController::class,'UploadHomeWork'] );
            Route::get('/diak/hazifeladat/letoltes/{homewokID}',[App\Http\Controllers\Student\StudentFunctionsController::class,'DownloadHomeWork']);
    });

    Route::group(['middleware' => 'auth:teacher'], function () {
        Route::get('/tanar/ertekelesek',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Ratings']);
        Route::get('/tanar/tanora/hazifeladatok/{lessonID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'HomeWorks']);
        Route::get('/tanar/figyelmeztetesek',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Warnings']);
        Route::get('/tanar/tanorak',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Lessons']);
        Route::get('/tanar/tantargyak',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Subjects']);
        Route::get('/tanar/osztaly',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SchoolClasseWithStudents']);
        Route::get('/tanar/osztaly/osztalytarsak/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'ClassStudents']);
        Route::get('/tanar/naptar/tanorak/{tanoraid}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'CalendarLesson']);
        Route::get('/tanar/tantargy/orak/{tantargyid}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SubjectLessons']);
        Route::post('/tanar/hazifeladat/feltoltes',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'UploadHomeWork'] );
        Route::get('/tanar/hazifeladat/letoltes/{homewokID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'DownloadHomeWork']);
    });
    Route::group(['middleware' => 'auth:studparent'], function () {
        Route::get('/tanar/ertekelesek',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Ratings']);
        Route::get('/tanar/tanora/hazifeladatok/{lessonID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'HomeWorks']);
        Route::get('/tanar/figyelmeztetesek',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Warnings']);
        Route::get('/tanar/tanorak',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Lessons']);
        Route::get('/tanar/tantargyak',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Subjects']);
        Route::get('/tanar/osztaly',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SchoolClasseWithStudents']);
        Route::get('/tanar/osztaly/osztalytarsak/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'ClassStudents']);
        Route::get('/tanar/naptar/tanorak/{tanoraid}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'CalendarLesson']);
        Route::get('/tanar/tantargy/orak/{tantargyid}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SubjectLessons']);
        Route::post('/tanar/hazifeladat/feltoltes',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'UploadHomeWork'] );
        Route::get('/tanar/hazifeladat/letoltes/{homewokID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'DownloadHomeWork']);
    });
    Route::group(['middleware' => 'auth:headUser'], function () {
        Route::get('/tanar/ertekelesek',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Ratings']);
        Route::get('/tanar/tanora/hazifeladatok/{lessonID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'HomeWorks']);
        Route::get('/tanar/figyelmeztetesek',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Warnings']);
        Route::get('/tanar/tanorak',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Lessons']);
        Route::get('/tanar/tantargyak',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Subjects']);
        Route::get('/tanar/osztaly',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SchoolClasseWithStudents']);
        Route::get('/tanar/osztaly/osztalytarsak/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'ClassStudents']);
        Route::get('/tanar/naptar/tanorak/{tanoraid}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'CalendarLesson']);
        Route::get('/tanar/tantargy/orak/{tantargyid}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SubjectLessons']);
        Route::post('/tanar/hazifeladat/feltoltes',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'UploadHomeWork'] );
        Route::get('/tanar/hazifeladat/letoltes/{homewokID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'DownloadHomeWork']);
    });
});



