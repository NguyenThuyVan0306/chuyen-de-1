<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'admin') {
            if (Auth::user()->role === 'leader') {
                return redirect()->route('leader.home')->with('error', 'Bạn không có quyền truy cập trang admin');
            }
            return redirect()->route('member.home')->with('error', 'Bạn không có quyền truy cập trang admin');
        }

        return $next($request);
    }
}