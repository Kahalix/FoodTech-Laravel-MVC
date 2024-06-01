<?php
// app/Http/Middleware/CheckPosition.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPosition
{
    public function handle(Request $request, Closure $next, $position)
    {
        $user = Auth::user();

        if ($user && $user->position === $position) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
