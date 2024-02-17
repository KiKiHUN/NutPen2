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
        $Isbanned=BannedIP::where([
            'clientID' => $request['_clientid']
        ])->first();
        if ($Isbanned) {
            abort(403, "Hehe Bannhammer lecsapott ");
        }

        return $next($request);
    }

}
