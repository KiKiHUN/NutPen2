<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DatabaseController;
use App\Http\Middleware\BlockIpMiddleware;
use App\Models\Admin;
use App\Models\BannedIP;
use App\Models\HeadUser;
use App\Models\Student;
use App\Models\StudParent;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\CustomClasses\PwHasher;

class LoginController extends Controller
{
    public static function LoggedInBycookie()
    {
        if(Auth::guard('admin')->check()||
        Auth::guard('headUser')->check()||
        Auth::guard('teacher')->check()||
        Auth::guard('student')->check()||
        Auth::guard('studparent')->check())
        {
            return true;
        }else
        {
            return false;
        }
    }
    
    public function LoginCall(Request $request)
    {
        $allowed=DatabaseController::ChechkIfAllowedToLogin();
        if (self::LoggedInBycookie()) 
        {
            return redirect('/vezerlopult');
        }
        if ((Session::get('voltproba'))) {
            if(!$request->hasCookie('id'))
            {
                return response(view('login',['voltProba'=>true,'enabledToLogin'=>$allowed]))->cookie('id',Str::uuid()->toString(),2147483647);
            }
            return view('login',['voltProba'=>true,'enabledToLogin'=>$allowed]);
        }else
        {
            if(!$request->hasCookie('id'))
            {
                return response(view('login',['voltProba'=>false,'enabledToLogin'=>$allowed]))->cookie('id',Str::uuid()->toString(),2147483647);
            }
            return view('login',['voltProba'=>false,'enabledToLogin'=>$allowed]);

        }
    }

    public function LoginAttempt(Request $request)
    {

        $key = $this->throttleKey($request->cookie('id'));
        $limitedTime = $this->ensureIsNotRateLimited($key,$request->getClientIp());
        RateLimiter::hit($key, 180);
       
        if ($limitedTime == -1) {
            $user=null;
            $azonositoValaszto = mb_substr($request['ID'], 0, 1);
 
            switch ($azonositoValaszto) {
                case 'a':
                    $user = Admin::where([
                        'UserID' => $request['ID']
                    ])->first();
                    if ($user) {
                        if (!PwHasher::PWCompare($request['password'],$user->password)) {
                            $user=null;
                        }
                    }
                        
                    break;
                case 's':
                    $user = Student::where([
                        'UserID' => $request['ID']
                    ])->first();
                    if ($user) {
                        if (!PwHasher::PWCompare($request['password'],$user->password)) {
                            $user=null;
                        }
                    }
                    break;
                case 't':
                    $user = Teacher::where([
                        'UserID' => $request['ID']
                    ])->first();
                    if ($user) {
                        if (!PwHasher::PWCompare($request['password'],$user->password)) {
                            $user=null;
                        }
                    }
                    break;
                case 'p':
                    $user = StudParent::where([
                        'UserID' => $request['ID']
                    ])->first();
                    if ($user) {
                        if (!PwHasher::PWCompare($request['password'],$user->password)) {
                            $user=null;
                        }
                    }
                    break;
                case 'h':
                    $user = HeadUser::where([
                        'UserID' => $request['ID']
                    ])->first();
                    if ($user) {
                        if (!PwHasher::PWCompare($request['password'],$user->password)) {
                            $user=null;
                        }
                    }
                    break;
            }

            if ($user)
            {
                $user->update(['LastLogin' => date('Y-m-d H:i:s')]);
                $user->save();
                $this->registerGuard($azonositoValaszto,$user);
                RateLimiter::clear($key);
                return redirect('/vezerlopult');
            } else
            {
            error_log("Login failed: ID=" . $request->post('ID') ." Key: ".$key);
                return redirect('/login')->with('voltproba', true);
            }
        } else
        {
            return redirect('/login')->
                with('message', 'Túl sok próbálkozás! '.
                    $limitedTime.
                    ' másodpercig letiltva a bejelentkezés.')->
                with('voltproba', true);
        }
    }
    
    public function ensureIsNotRateLimited($key,$IP)
    {
        if (!RateLimiter::tooManyAttempts($key, 50)) {
            return -1;
        }
        if (RateLimiter::tooManyAttempts($key, 100)) {
           
            if (!BannedIP::EditUUIDBannIfExist($key,1)) {
                if (!BannedIP::AddNewBann($key,1,$IP,0)) {
                    Log::channel('bannedIPs')->warning("Error banning:".$key." ID");
                }else {
                    Log::channel('bannedIPs')->warning($key." Banned");
                }
            }else {
                Log::channel('bannedIPs')->warning($key." Banned");
            }
        }
        $seconds=RateLimiter::availableIn($key);
        Log::channel('loginAttempts')->warning("Too many attempts: key=" . $key." Remaining time: ".$seconds." sec");
        return $seconds ;
    }

    public function throttleKey($ID): string
    {
        return Str::transliterate(Str::lower($ID));
    }
    
    

    function registerGuard($firstChar,$user)
    {
       
        switch ($firstChar) {
            case 'h':
                Auth::guard('headUser')->login($user);
                break;
            case 'a':
                Auth::guard('admin')->login($user);
                break;
            case 's':
                Auth::guard('student')->login($user);
                break;
            case 'p':
                Auth::guard('studparent')->login($user);
                break;
            case 't':
                Auth::guard('teacher')->login($user);
                break;
        }
       
    }
   
}
