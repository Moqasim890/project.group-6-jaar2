<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnderhoudMode
{
    public function handle(Request $request, Closure $next)
    {
        // check env/config flag
        if (config('app.onderhoud') === true) {
            // only allow the onderhoud page itself
            if (!$request->is('onderhoud')) {
                return redirect()->route('onderhoud');
            }
        }

        return $next($request);
    }
}
