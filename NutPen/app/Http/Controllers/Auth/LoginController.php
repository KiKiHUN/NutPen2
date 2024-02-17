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

    public function LoginCall()
    {
        $allowed=DatabaseController::ChechkIfAllowedToLogin();
        if (
            Auth::guard('admin')->check()||
            Auth::guard('headUser')->check()||
            Auth::guard('teacher')->check()||
            Auth::guard('student')->check()||
            Auth::guard('studparent')->check()
            ) 
        {
            return redirect('/vezerlopult');
        }
        if ((Session::get('voltproba'))) {
            return view('login',['voltProba'=>true,'enabledToLogin'=>$allowed,'ClientID'=>Str::uuid()->toString()]);
        }else
        {
            return view('login',['voltProba'=>false,'enabledToLogin'=>$allowed,'ClientID'=>Str::uuid()->toString()]);
        }
    }

    public function LoginAttempt(Request $request)
    {

        $key = $this->throttleKey($request['_clientid']);
        $limitedTime = $this->ensureIsNotRateLimited($key);
        RateLimiter::hit($key, 300);
       
        if ($limitedTime == -1) {
            $user=null;
            $azonositoValaszto = mb_substr($request['ID'], 0, 1);
 
            switch ($azonositoValaszto) {
                case 'a':
                    $user = Admin::where([
                        'UserID' => $request['ID'],
                        'password' => PwHasher::hasheles($request['password'])
                    ])->first();
                    break;
                case 's':
                    $user = Student::where([
                        'UserID' => $request['ID'],
                        'password' => PwHasher::hasheles($request['password'])
                    ])->first();
                    break;
                case 't':
                    $user = Teacher::where([
                        'UserID' => $request['ID'],
                        'password' => PwHasher::hasheles($request['password'])
                    ])->first();
                    break;
                case 'p':
                    $user = StudParent::where([
                        'UserID' => $request['ID'],
                        'password' => PwHasher::hasheles($request['password'])
                    ])->first();
                    break;
                case 'h':
                    $user = HeadUser::where([
                        'UserID' => $request['ID'],
                        'password' => PwHasher::hasheles($request['password'])
                    ])->first();
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
                with('message', 'Én találjam ki a jelszavad? '.
                    $limitedTime.
                    ' másodpercig gondolkozz el rajta.')->
                with('voltproba', true);
        }
    }
    
    public function ensureIsNotRateLimited($key)
    {
        if (!RateLimiter::tooManyAttempts($key, 5)) {
            return -1;
        }
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $banned = new BannedIP();
            $banned->IP = $key;
            $banned->save();
            Log::channel('bannedIPs')->warning($key." Banned");
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
                Auth::guard('parent')->login($user);
                break;
            case 't':
                Auth::guard('teacher')->login($user);
                break;
        }
       
    }
   
}
