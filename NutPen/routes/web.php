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
        Route::get('/ujfelhasznalo',[App\Http\Controllers\Admin\AdminFunctionsController::class,'NewUserPage']);
        Route::get('/felhasznalok',[App\Http\Controllers\Admin\AdminFunctionsController::class,'UsersPage']);
        Route::get('/felhasznalok/{filter}',[App\Http\Controllers\Admin\AdminFunctionsController::class,'UsersPageFilter']);
    });
   

});



