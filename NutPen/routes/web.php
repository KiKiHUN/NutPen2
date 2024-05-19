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
        Route::get('/msgstatusedit',[App\Http\Controllers\MainRouterController::class,'MsgstatusEdit']);
        
        Route::get('/jelszoVisszaallitas',[App\Http\Controllers\MainRouterController::class,'PWResetPage']);
        Route::post('/jelszoVisszaallitas/save',[App\Http\Controllers\PWResetController::class,'SavePW']);
        Route::get('/kijelentkezes',[App\Http\Controllers\LogoutController::class,'logout']);

        Route::get('/naptar',[App\Http\Controllers\MessageController::class,'Calendar']);
        Route::get('/naptar/diak/{studentID}',[App\Http\Controllers\MessageController::class,'CalendarOnStudent']);
        Route::get('/naptar/tanorak/{lessonID}',[App\Http\Controllers\MessageController::class,'CalendarLesson']);
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

         //diak-szulo
         Route::get('/admin/kapcsolat/szulodiak',[App\Http\Controllers\Admin\AdminFunctionsController::class,'StudParConns']);
         Route::get('/admin/kapcsolat/ujszulodiak',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewStudPar']);
         Route::get('/admin/kapcsolat/szulodiaktorles/{studentID}/{parentID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveStudPar']);
         Route::post('/admin/kapcsolat/ujszulodiakmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveStudPar']);
        

        //bannolás
        Route::get('/admin/kitiltottak',[App\Http\Controllers\Admin\AdminFunctionsController::class,'BannedUSers']);
        Route::get('/admin/ujkitiltas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewBanning']);
        Route::post('/admin/ujkitiltasmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveNewBanning']);
        Route::post('/admin/kitiltasmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditBannings']);

        //mentes
        Route::get('/admin/confirm/{link}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Confirm']);
        Route::get('/admin/doevvege',[App\Http\Controllers\Admin\AdminFunctionsController::class,'BackupYearAndNuke']);
        Route::get('/admin/nuke',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Nuke']);

        //banner
        Route::get('/admin/banner',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Banner']);
        Route::post('/admin/bannervalasztas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'BannerChange']);
        Route::get('/admin/ujbanner',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewBannerPage']);
        Route::post('/admin/ujbannermentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveBanner']);
        Route::get('/admin/bannermodositas/{bannerID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditBannerPage']);
        Route::post('/admin/bannermodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditBanner']);
        Route::get('/admin/bannertorles/{bannerID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveBanner']);
      

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

        //hiányzások
        Route::get('/admin/igazolastipusok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'VerifTypes']);
        Route::get('/admin/ujigazolastipus',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewVerifType']);
        Route::post('/admin/ujigazolastipusmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveVerifType']);
        Route::get('/admin/igazolastipusmodositas/{verifID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditVerifTypegPage']);
        Route::post('/admin/igazolastipusmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditVerifType']);

        Route::get('/admin/hianyzasok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RecentMissings']);
        Route::get('/admin/hianyzasmodositas/{missID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditStudentMissingPage']);
        Route::get('/admin/hianyzastorles/{missID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveStudentMissing']);
        Route::post('/admin/hianyzasmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditStudentMissing']);

        Route::get('/admin/hianyzasok/tanora/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'MissingsLessons']);
        Route::get('/admin/tanorak/ujhianyzas/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'AddNewissingToLessonClass']);
        Route::post('/admin/tanorak/hianyzasmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveNewissingToLessonClass']);



        
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
        Route::get('/admin/hazifeladatok/tanora/{lessonID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'StudentsHomeWorksByLesson']);

       
        Route::get('/admin/naptar/esemenyek',[App\Http\Controllers\Admin\AdminFunctionsController::class,'CalendarEvents']);
        Route::get('/admin/esemenyek',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Events']);
        Route::get('/admin/ujesemeny',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewEvent']);
        Route::post('/admin/ujesemeny',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveEvent']);
        Route::get('/admin/esemenytorles/{eventID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveEvent']);
        Route::get('/admin/esemenymodositas/{eventID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditEventPage']);
        Route::post('/admin/esemenymodositas/',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditEvent']);
      
       
    });
   
    Route::group(['middleware' => 'auth:student'], function () {
            Route::get('/diak/ertekelesek',[App\Http\Controllers\Student\StudentFunctionsController::class,'OwnRatings']);
            Route::get('/diak/hazifeladatok',[App\Http\Controllers\Student\StudentFunctionsController::class,'HomeWorks']);
            Route::get('/diak/figyelmeztetesek',[App\Http\Controllers\Student\StudentFunctionsController::class,'Warnings']);
            Route::get('/diak/kesesek',[App\Http\Controllers\Student\StudentFunctionsController::class,'Missings']);
            Route::get('/diak/tanorak',[App\Http\Controllers\Student\StudentFunctionsController::class,'Lessons']);
            Route::get('/diak/tantargyak',[App\Http\Controllers\Student\StudentFunctionsController::class,'Subjects']);
            Route::get('/diak/osztaly',[App\Http\Controllers\Student\StudentFunctionsController::class,'SchoolClasseWithStudents']);
            Route::get('/diak/osztaly/osztalytarsak/{classID}',[App\Http\Controllers\Student\StudentFunctionsController::class,'ClassStudents']);
            Route::get('/diak/tantargy/orak/{tantargyid}',[App\Http\Controllers\Student\StudentFunctionsController::class,'SubjectLessons']);
            Route::post('/diak/hazifeladat/feltoltes',[App\Http\Controllers\Student\StudentFunctionsController::class,'UploadHomeWork'] );
            Route::get('/diak/hazifeladat/letoltes/{homewokID}',[App\Http\Controllers\Student\StudentFunctionsController::class,'DownloadHomeWork']);
    });

    Route::group(['middleware' => 'auth:teacher'], function () {
      
      
        Route::get('/tanar/figyelmeztetesek',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Warnings']);
        Route::get('/tanar/ujfigyelmeztetes',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'NewWarning']);
        Route::post('/tanar/ujfigyelmeztetesmentes',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SaveWarning']);

        Route::get('/tanar/tanorak',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'Lessons']);
        Route::get('/tanar/osztalyok/tanora/{tanoraid}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'LessonsClasses']);

        Route::get('/tanar/ertekelesek/tanora/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'RatingsLessons']);
        Route::get('/tanar/tanorak/ujertekeles/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'AddNewRatingToLessonClass']);
        Route::post('/tanar/tanorak/ertekelesekmentes',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SaveNewRatingToLessonClass']);
        Route::get('/tanar/ertekelesmodositas/{gradeID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'EditStudentRatingPage']);
        Route::post('/tanar/ertekelesmodositas',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'EditStudentRating']);


        Route::get('/tanar/hianyzasok/tanora/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'MissingsLessons']);
        Route::get('/tanar/tanorak/ujhianyzas/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'AddNewissingToLessonClass']);
        Route::post('/tanar/tanorak/hianyzasmentes',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SaveNewissingToLessonClass']);
        Route::get('/tanar/hianyzasmodositas/{missID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'EditStudentMissingPage']);
        Route::post('/tanar/hianyzasmodositas',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'EditStudentMissing']);


        Route::get('/tanar/hazifeladatok/tanora/{lessonID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'StudentsHomeWorksByLesson']);
        Route::get('/tanar/ujhazifeladat/{lessonID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'NewHomeWork']);
        Route::post('/tanar/ujhazifeladatmentes',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SaveHomeWork']);
        Route::get('/tanar/hazifeladat/osztalyok/{homewokID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'HomeWorkClasses']);
        Route::get('/tanar/hazifeladatok/diakok/{homewokID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'StudentsHomeWorks']);
        Route::get('/tanar/hazifeladatmodositas/{homewokID}/{lessonID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'EditHomeWorkPage']);
        Route::post('/tanar/hazifeladatmodositas',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'EditHomeWork']);
        Route::get('/tanar/hazifeladattorles/{homewokID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'RemoveHomeWork']);
        Route::get('/tanar/bekuldotthazifeladat/letoltes/{homewokID}/{studentID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'DownloadHomeWork']);
        Route::get('/tanar/bekuldotthazifeladat/torles/{homewokID}/{studentID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'RemoveStudentHomeWork']);
        Route::post('/tanar/hfkomment',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'EditHomeWorkComment']);



        Route::get('/tanar/osztalyok',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'SchoolClasses']);
        Route::get('/tanar/osztaly/diakok/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'ClassStudents']);
        Route::get('/tanar/diak/figyelmeztetesek/{studID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'StudWarnings']);
        Route::get('/tanar/osztaly/tanorak/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'ClassLessons']);
        Route::get('/tanar/Osztalyhianyzasok/tanora/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'StudentMissingsLessons']);
        Route::get('/tanar/osztalyhianyzasmodositas/{missID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'EditClassStudentMissingPage']);
        Route::post('/tanar/osztalyhianyzasmodositas',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'EditClassStudentMissing']);
        Route::get('/tanar/ertekelesek/Osztalytanorak/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Teacher\TeacherFunctionController::class,'RatingsStudentLessons']);

        

    });
    Route::group(['middleware' => 'auth:studparent'], function () {
        
        Route::get('/szulo/diakok',[App\Http\Controllers\StudParent\StudParentController::class,'Students']);
        Route::get('/szulo/ertekelesek/{studID}',[App\Http\Controllers\StudParent\StudParentController::class,'Ratings']);
        Route::get('/szulo/figyelmeztetesek/{studID}',[App\Http\Controllers\StudParent\StudParentController::class,'Warnings']);
        Route::get('/szulo/kesesek/{studID}',[App\Http\Controllers\StudParent\StudParentController::class,'Missings']);
        Route::get('/szulo/tanorak/{studID}',[App\Http\Controllers\StudParent\StudParentController::class,'Lessons']);
        Route::get('/szulo/hazifeladatok/{studID}',[App\Http\Controllers\StudParent\StudParentController::class,'HomeWorks']);
        Route::get('/szulo/hianyzasigazolas/{missID}',[App\Http\Controllers\StudParent\StudParentController::class,'EditMissings']);

        Route::get('/szulo/hazifeladat/letoltes/{homewokID}',[App\Http\Controllers\StudParent\StudParentController::class,'DownloadHomeWork']);

      
    });
    Route::group(['middleware' => 'auth:headUser'], function () {
        //felhasznalo
        Route::get('/fo/felhasznalok',[App\Http\Controllers\HeadUser\HeadUSerController::class,'UsersPage']);
        Route::get('/fo/felhasznalok/{filter}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'UsersPageFilter']);
        Route::get('/fo/ujfelhasznalo',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewUserPage']);
        Route::get('/fo/felhasznalomodositas/{UserID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditUserPage']);
        Route::post('/fo/felhasznalomodositas/mentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditUser']);
        Route::post('/fo/ujfelhasznalomentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'AddNewUser']);

        //rang
        Route::get('/fo/rangok',[App\Http\Controllers\HeadUser\HeadUSerController::class,'Roles']);

         //diak-szulo
         Route::get('/fo/kapcsolat/szulodiak',[App\Http\Controllers\HeadUser\HeadUSerController::class,'StudParConns']);
         Route::get('/fo/kapcsolat/ujszulodiak',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewStudPar']);
         Route::get('/fo/kapcsolat/szulodiaktorles/{studentID}/{parentID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RemoveStudPar']);
         Route::post('/fo/kapcsolat/ujszulodiakmentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveStudPar']);
        

        //bannolás
        Route::get('/fo/kitiltottak',[App\Http\Controllers\HeadUser\HeadUSerController::class,'BannedUSers']);
        Route::get('/fo/ujkitiltas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewBanning']);
        Route::post('/fo/ujkitiltasmentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveNewBanning']);
        Route::post('/fo/kitiltasmodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditBannings']);

        //mentes
        Route::get('/fo/confirm/{link}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'Confirm']);
        Route::get('/fo/doevvege',[App\Http\Controllers\HeadUser\HeadUSerController::class,'BackupYearAndNuke']);
        Route::get('/fo/nuke',[App\Http\Controllers\HeadUser\HeadUSerController::class,'Nuke']);

        //banner
        Route::get('/fo/banner',[App\Http\Controllers\HeadUser\HeadUSerController::class,'Banner']);
        Route::post('/fo/bannervalasztas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'BannerChange']);
        Route::get('/fo/ujbanner',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewBannerPage']);
        Route::post('/fo/ujbannermentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveBanner']);
        Route::get('/fo/bannermodositas/{bannerID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditBannerPage']);
        Route::post('/fo/bannermodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditBanner']);
        Route::get('/fo/bannertorles/{bannerID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RemoveBanner']);
      

        //osztályok
        Route::get('/fo/osztalyok',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SchoolClasses']);
        Route::get('/fo/osztaly/diakok/{classID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'ClassStudents']);
        Route::get('/fo/ujosztaly',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewClass']);
        Route::get('/fo/osztalymodositas/{classID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditClassPage']);
        Route::post('/fo/ujosztalymentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveClass']);
        Route::post('/fo/osztalymodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditClass']);
        Route::get('/fo/osztalyok/diakhozzad/{classID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'AddStudentToClass']);
        Route::post('/fo/osztalyok/diakhozzad/mentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveStudentToClass']);
        Route::get('/fo/osztaly/{classID}/diaktorles/{studentID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RemoveStudentFromClass']);

        //tantárgyak
        Route::get('/fo/tantargyak',[App\Http\Controllers\HeadUser\HeadUSerController::class,'Subjects']);
        Route::get('/fo/tantargy/orak/{tantargyid}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SubjectLessons']);

        Route::get('/fo/ujtantargy',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewSubject']);
        Route::get('/fo/tantargymodositas/{tantargyid}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditSubjectPage']);
        Route::post('/fo/ujtantargymentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveSubject']);
        Route::post('/fo/tantargymodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditSubject']);

        //tanorak
        Route::get('/fo/tanorak',[App\Http\Controllers\HeadUser\HeadUSerController::class,'Lessons']);
        Route::get('/fo/osztalyok/tanora/{tanoraid}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'LessonsClasses']);
        Route::get('/fo/ujtanora',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewLesson']);
        Route::get('/fo/tanoramodositas/{tanoraid}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditLessonPage']);
        Route::post('/fo/ujtanoramentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveLesson']);
        Route::post('/fo/tanoramodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditLesson']);
        Route::get('/fo/tanorak/osztalyhozzad/{lessonID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'AddClassToLesson']);
        Route::post('/fo/tanorak/osztalyhozzad/mentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveClassToLesson']);
        Route::get('/fo/tanora/{lessonID}/osztalytorles/{classID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RemoveClassFromLesson']);

        
         //ertekelesek
        Route::get('/fo/ertekelestipusok',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RatingTypes']);
        Route::get('/fo/ujertekelestipus',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewRatingType']);
        Route::get('/fo/ertekelestipusmodositas/{gradeID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditRatinTypegPage']);
        Route::get('/fo/ertekelestipustorles/{gradeID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RemoveRatingType']);
        Route::post('/fo/ujertekelestipusmentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveRatingType']);
        Route::post('/fo/ertekelestipusmodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditRatingType']);
        
        Route::get('/fo/ertekelesek/tanora/{lessonID}/osztaly/{classID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RatingsLessons']);
        Route::get('/fo/tanorak/ujertekeles/{lessonID}/osztaly/{classID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'AddNewRatingToLessonClass']);
        Route::post('/fo/tanorak/ertekelesekmentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveNewRatingToLessonClass']);

        Route::get('/fo/ertekelesek',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RecentRatings']);
        Route::get('/fo/ertekelesmodositas/{gradeID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditStudentRatingPage']);
        Route::get('/fo/ertekelestorles/{gradeID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RemoveStudentGrade']);
        Route::post('/fo/ertekelesmodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditStudentRating']);

        //hiányzások
        Route::get('/fo/igazolastipusok',[App\Http\Controllers\HeadUser\HeadUSerController::class,'VerifTypes']);
        Route::get('/fo/ujigazolastipus',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewVerifType']);
        Route::post('/fo/ujigazolastipusmentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveVerifType']);
        Route::get('/fo/igazolastipusmodositas/{verifID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditVerifTypegPage']);
        Route::post('/fo/igazolastipusmodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditVerifType']);

        Route::get('/fo/hianyzasok',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RecentMissings']);
        Route::get('/fo/hianyzasmodositas/{missID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditStudentMissingPage']);
        Route::get('/fo/hianyzastorles/{missID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RemoveStudentMissing']);
        Route::post('/fo/hianyzasmodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditStudentMissing']);

        Route::get('/fo/hianyzasok/tanora/{lessonID}/osztaly/{classID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'MissingsLessons']);
        Route::get('/fo/tanorak/ujhianyzas/{lessonID}/osztaly/{classID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'AddNewissingToLessonClass']);
        Route::post('/fo/tanorak/hianyzasmentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveNewissingToLessonClass']);



        
        //figyelmeztetések
        Route::get('/fo/figyelmeztetesek',[App\Http\Controllers\HeadUser\HeadUSerController::class,'Warnings']);
        Route::get('/fo/ujfigyelmeztetes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewWarning']);
        Route::get('/fo/figyelmeztetesmodositas/{warningID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditWarningPage']);
        Route::post('/fo/ujfigyelmeztetesmentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveWarning']);
        Route::post('/fo/figyelmeztetesmodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditWarning']);
        Route::get('/fo/figyelmeztetestorles/{warningID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RemoveWarning']);

        //házifeladatok
        Route::get('/fo/hazifeladatok',[App\Http\Controllers\HeadUser\HeadUSerController::class,'HomeWorks']);
        Route::get('/fo/hazifeladatok/diakok/{homewokID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'StudentsHomeWorks']);
        Route::get('/fo/hazifeladat/osztalyok/{homewokID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'HomeWorkClasses']);
        Route::get('/fo/ujhazifeladat',[App\Http\Controllers\HeadUser\HeadUSerController::class,'NewHomeWork']);
        Route::get('/fo/hazifeladatmodositas/{homewokID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditHomeWorkPage']);
        Route::post('/fo/ujhazifeladatmentes',[App\Http\Controllers\HeadUser\HeadUSerController::class,'SaveHomeWork']);
        Route::post('/fo/hazifeladatmodositas',[App\Http\Controllers\HeadUser\HeadUSerController::class,'EditHomeWork']);
        Route::get('/fo/hazifeladattorles/{homewokID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RemoveHomeWork']);
        Route::get('/fo/bekuldotthazifeladat/letoltes/{homewokID}/{studentID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'DownloadHomeWork']);
        Route::get('/fo/bekuldotthazifeladat/torles/{homewokID}/{studentID}',[App\Http\Controllers\HeadUser\HeadUSerController::class,'RemoveStudentHomeWork']);
    });
});



