<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Số lượng CLB
        $totalClubs = Club::count();
        $approvedClubs = Club::where('status', 'approved')->count();
        $pendingClubs = Club::where('status', 'pending')->count();

        // 2. Thành viên
        $totalUsers = User::count();
        $totalMembers = User::where('role', 'member')->count();
        $totalLeaders = User::where('role', 'leader')->count();
        $activeClubMembers = \App\Models\ClubMember::where('status', 'approved')->distinct('user_id')->count();

        // 3. Hoạt động (Sự kiện)
        $totalEvents = Event::count();
        $upcomingEvents = Event::where('start_time', '>', now())->count();
        
        // 4. Các yêu cầu mới (Để duyệt nhanh trên Dashboard)
        $pendingClubList = Club::with('leader')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();
        
        $pendingClubsCount = $pendingClubs;

        return view('admin.dashboard', compact(
            'totalClubs', 'approvedClubs', 'pendingClubs',
            'totalUsers', 'totalMembers', 'totalLeaders', 'activeClubMembers',
            'totalEvents', 'upcomingEvents',
            'pendingClubsCount', 'pendingClubList'
        ));
    }
}
