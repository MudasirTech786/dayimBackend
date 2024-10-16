<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddContext
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
        // Add your context logic here. For example:
        // \Flare::addContext([
        //     'key' => 'value',
        // ]);

        return $next($request);
    }
}
