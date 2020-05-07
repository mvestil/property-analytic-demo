<?php

namespace App\Http\Middleware;

use Closure;

class CustomAuthenticate
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
        /**
         * Validate the access token here (e.g Authorization Bearer from the header)
         * We can use tymondesigns/jwt-auth package or the built-in Laravel Passport.
         * For demo purposes, there's nothing in here. It's just to show how token works
         */
        // $this->validateTokenHere()

        return $next($request);
    }
}
