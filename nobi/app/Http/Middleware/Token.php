<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
		$cekdata = DB::table('oauth_access_tokens')->where('id', $token)->first();
		if($cekdata == null)
		{
			return response(['error'=>'Unauthorized', 'status' => 401], 401);
		}
		else
		{
			$now = Carbon::now();
			$date1=date_create($cekdata->created_at);
			$date2=date_create($now);
			$diff=date_diff($date2,$date1);
			$getdiff = $diff->format("%R%a");
			if($getdiff < 0)
			{
				return response(['error'=>'Token Expired', 'status' => 498], 498);
			}
			else
			{
				return $next($request);				
			}
		}	
    }
}
