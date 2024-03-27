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
        Route::get('/felhasznalok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'UsersPage']);
        Route::get('/felhasznalok/{filter}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'UsersPageFilter']);

        Route::get('/ujfelhasznalo',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewUserPage']);
        Route::get('/felhasznalomodositas/{UserID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditUserPage']);
        Route::post('/felhasznalomodositas/mentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditUser']);
        Route::post('/ujfelhasznalomentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'AddNewUser']);

        //rang
        Route::get('/rangok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Roles']);

        Route::get('/ujrang',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewRole']);
        Route::get('/rangmodositas/{rangID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditRolePage']);
        Route::post('/ujrangmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveRole']);
        Route::post('/rangmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditRole']);
        

        //bannolás
        Route::get('/kitiltottak',[App\Http\Controllers\Admin\AdminFunctionsController::class,'BannedUSers']);

        Route::get('/ujkitiltas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewBanning']);
        Route::post('/ujkitiltasmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveNewBanning']);
        Route::post('/kitiltasmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditBannings']);


        //osztályok
        Route::get('/osztalyok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SchoolClasses']);
        Route::get('/osztaly/diakok/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'ClassStudents']);

        Route::get('/ujosztaly',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewClass']);
        Route::get('/osztalymodositas/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditClassPage']);
        Route::post('/ujosztalymentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveClass']);
        Route::post('/osztalymodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditClass']);
        Route::get('/osztalyok/diakhozzad/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'AddStudentToClass']);
        Route::post('/osztalyok/diakhozzad/mentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveStudentToClass']);
        Route::get('/osztaly/{classID}/diaktorles/{studentID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveStudentFromClass']);

        //tantárgyak
        Route::get('/tantargyak',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Subjects']);
        Route::get('/tantargy/orak/{tantargyid}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SubjectLessons']);

        Route::get('/ujtantargy',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewSubject']);
        Route::get('/tantargymodositas/{tantargyid}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditSubjectPage']);
        Route::post('/ujtantargymentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveSubject']);
        Route::post('/tantargymodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditSubject']);

        //tanorak
        Route::get('/tanorak',[App\Http\Controllers\Admin\AdminFunctionsController::class,'Lessons']);
        Route::get('/osztalyok/tanora/{tanoraid}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'LessonsClasses']);

        Route::get('/ujtanora',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewLesson']);
        Route::get('/tanoramodositas/{tanoraid}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditLessonPage']);
        Route::post('/ujtanoramentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveLesson']);
        Route::post('/tanoramodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditLesson']);
        Route::get('/naptar/tanorak/{tanoraid}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'CalendarLesson']);

        Route::get('/tanorak/osztalyhozzad/{lessonID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'AddClassToLesson']);
        Route::post('/tanorak/osztalyhozzad/mentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveClassToLesson']);
        Route::get('/tanora/{lessonID}/osztalytorles/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveClassFromLesson']);

        
         //kapcsolatok


         //ertekelesek
         Route::get('/ertekelestipusok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RatingTypes']);
         Route::get('/ujertekelestipus',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewRatingType']);
         Route::get('/ertekelestipusmodositas/{gradeID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditRatinTypegPage']);
         Route::get('/ertekelestipustorles/{gradeID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveRatingType']);
         Route::post('/ujertekelestipusmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveRatingType']);
         Route::post('/ertekelestipusmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditRatingType']);
         Route::get('/ertekelesek/tanora/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RatingsLessons']);
         Route::get('/tanorak/ujertekeles/{lessonID}/osztaly/{classID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'AddNewRatingToLessonClass']);
         Route::post('/tanorak/ertekelesekmentes',[App\Http\Controllers\Admin\AdminFunctionsController::class,'SaveNewRatingToLessonClass']);

         Route::get('/ertekelesek',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RecentRatings']);
         Route::get('/ertekelesmodositas/{gradeID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditStudentRatingPage']);
         Route::get('/ertekelestorles/{gradeID}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'RemoveStudentGrade']);
         Route::post('/ertekelesmodositas',[App\Http\Controllers\Admin\AdminFunctionsController::class,'EditStudentRating']);
    });
   

});



