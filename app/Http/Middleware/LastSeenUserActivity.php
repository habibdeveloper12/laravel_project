<?php

namespace App\Http\Middleware;


use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LastSeenUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            $expireTime = Carbon::now()->addMinute(3); // keep online for 1 min
            $stat = Cache::put('is_online'.Auth::user()->user_id, true, $expireTime);

            //Last Seen
           if ($stat){
               User::where('user_id', Auth::user()->user_id)->update(['last_seen' => Carbon::now()]);
           }


        }

        return $next($request);
    }

}
