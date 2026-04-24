<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLeader
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'leader') {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Bạn đã là admin, không cần truy cập trang trưởng nhóm');
            }
            return redirect()->route('member.home')->with('error', 'Bạn không có quyền truy cập trang dành cho trưởng nhóm');
        }

        return $next($request);
    }
}
