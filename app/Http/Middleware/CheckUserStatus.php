<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status === 'blocked') {
            $role = Auth::user()->role;
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($role === 'admin') {
                return redirect()->route('admin.login')->with('error', 'Tài khoản của bạn đã bị khóa');
            }

            return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa');
        }

        return $next($request);
    }
}