<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Авторизируйтесь!');
        }

        if (Auth::user()->role == $role) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'У вас нет доступа к этой странице');
    }
}
