<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Авторизируйтесь!');
        }

        if (Auth::user()->role === 2) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'У вас нет доступа к этой странице');
    }
}
