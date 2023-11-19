<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;

class CheckManagerRole
{
    public function handle(Request $request, Closure $next)
    {

        $user = $request->user();

        if (! $user || $user->role !== config('app.user_roles.manager')) {
            abort(403, 'Permission denied');
        }

        return $next($request);

    }
}
