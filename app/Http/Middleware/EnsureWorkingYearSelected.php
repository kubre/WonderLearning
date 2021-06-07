<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

class EnsureWorkingYearSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            auth()->user()->hasAccess('school.year')
            && !Session::has('_working_year')
        ) {
            return redirect()->route('school.select.year');
        }

        return $next($request);
    }
}
