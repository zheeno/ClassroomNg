<?php namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminMiddleware {

    public function handle($request, Closure $next)
    {

        if ( Auth::check() && Auth::user()->isAdmin() )
        {
            return $next($request);
        }

        return redirect('/errors/access_denied');

    }

}