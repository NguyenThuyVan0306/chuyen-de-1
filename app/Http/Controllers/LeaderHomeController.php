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

        $eventsQuery = Event::whereIn('club_id', $clubIds);
        $totalEvents = $eventsQuery->count();

        $now = \Carbon\Carbon::now();
        $upcomingEventsCount = Event::whereIn('club_id', $clubIds)->where('start_time', '>', $now)->count();
        $ongoingEventsCount = Event::whereIn('club_id', $clubIds)->where('start_time', '<=', $now)->where('end_time', '>=', $now)->count();
        $finishedEventsCount = Event::whereIn('club_id', $clubIds)->where('end_time', '<', $now)->count();

        $pendingMembers = \App\Models\ClubMember::whereIn('club_id', $clubIds)
            ->where('status', 'pending')
            ->count();

        return view('leader.dashboard', compact(
            'myManagedClubs', 
            'totalMembers', 
            'totalEvents', 
            'upcomingEventsCount',
            'ongoingEventsCount',
            'finishedEventsCount',
            'pendingMembers'
        ));
    }
}
