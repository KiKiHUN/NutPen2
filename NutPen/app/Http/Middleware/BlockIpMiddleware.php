<?php

namespace App\Http\Middleware;

use App\Models\BannedIP;
use BannedIPs;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockIpMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->hasCookie('id'))
        {
            $IsBanedByID=BannedIP::where([
                'clientID' => $request->cookie('id')
            ])->first();
            if ($IsBanedByID) {
                if ($IsBanedByID->UUIDBanned) {
                    abort(403, "Hehe Bannhammer lecsapott ");
                }
            }
           
            $IsBanedByIP=BannedIP::where([
                'clientIP' => $request->getClientIp()
            ])->first();
            if ($IsBanedByIP) {
                if ($IsBanedByIP->IPBanned) {
                    abort(403, "Hehe Bannhammer lecsapott ");
                }
            }
        }
        return $next($request);
    }

}
