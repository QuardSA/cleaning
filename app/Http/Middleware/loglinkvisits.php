<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogLinkVisits
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$request->wantsJson() && !$request->isMethod('POST')) {
            Log::info('User ' . (Auth::check() ? Auth::user()->email : 'Guest') . ' переход по ссылке ' . $request->url(), [
                'user_id' => Auth::check() ? Auth::id() : null,
                'user_name' => Auth::check() ? Auth::user()->name : null,
                'user_surname' => Auth::check() ? Auth::user()->surname : null,
                'user_lastname' => Auth::check() ? Auth::user()->lastname : null,
                'user_role' => Auth::check() ? Auth::user()->user_role->titlerole : null,
                'ip_address' => $request->ip(),
                'action' => 'переход по ссылке',
                'url' => $request->url(),
            ]);
        }

        return $response;
    }
}

