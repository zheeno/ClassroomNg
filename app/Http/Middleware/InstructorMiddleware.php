<?php namespace App\Http\Middleware;

use Closure;
use Auth;
class InstructorMiddleware {

    public function handle($request, Closure $next)
    {

        if ( Auth::check() && Auth::user()->isInstructor() )
        {
            return $next($request);
        }

        return redirect('/errors/access_denied');

    }

}