<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderHomeController extends Controller
{
    public function index()
    {
        $myManagedClubs = Club::where('user_id', Auth::id())->get();
        $clubIds = $myManagedClubs->pluck('id');

        $totalMembers = \App\Models\ClubMember::whereIn('club_id', $clubIds)
            ->where('status', 'approved')
            ->count();

        $totalEvents = Event::whereIn('club_id', $clubIds)->count();

        $pendingMembers = \App\Models\ClubMember::whereIn('club_id', $clubIds)
            ->where('status', 'pending')
            ->count();

        return view('leader.dashboard', compact('myManagedClubs', 'totalMembers', 'totalEvents', 'pendingMembers'));
    }
}
