<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class MemberHomeController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // 1. CLB mới nhất (Khám phá)
        $latestClubs = Club::where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();

        // 2. CLB của tôi (Đã tham gia)
        $myClubs = Club::whereHas('clubMembers', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'approved');
        })->latest()->get();

        // 3. Sự kiện từ các CLB đã tham gia
        $latestEvents = Event::with(['club', 'registrations' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->whereHas('club', function ($query) use ($userId) {
                $query->whereHas('clubMembers', function ($subQuery) use ($userId) {
                    $subQuery->where('user_id', $userId)
                             ->where('status', 'approved');
                });
            })
            ->latest('start_time')
            ->take(5)
            ->get();

        // 4. Các con số thống kê
        $joinedClubsCount = $myClubs->count();

        $pendingRegistrationsCount = \App\Models\Registration::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        return view('member.home', compact('latestClubs', 'myClubs', 'latestEvents', 'joinedClubsCount', 'pendingRegistrationsCount'));
    }
}