<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class LocaleMiddleware
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
        if(session()->has('site_language')) {
            app()->setLocale(session('site_language'));
//           Carbon::setLocale(session('site_language'));
        }
        return $next($request);
    }
}
