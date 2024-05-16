<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Redirect
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 2) {
                return redirect('admin');
            } elseif ($user->role == 3) {
                return redirect('manager');
            }
        }

        return $next($request);
    }
}
