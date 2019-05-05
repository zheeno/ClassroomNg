<?php namespace App\Http\Middleware;

use Closure;
use Auth;
class ModeratorMiddleware {

    public function handle($request, Closure $next)
    {

        if ( Auth::check() && Auth::user()->isModerator() )
        {
            return $next($request);
        }

        return redirect('/errors/access_denied');

    }

}