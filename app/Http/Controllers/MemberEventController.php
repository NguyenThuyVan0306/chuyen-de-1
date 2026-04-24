<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class MemberEventController extends Controller
{
    public function index()
    {
        $events = Event::with(['club', 'registrations' => function ($query) {
                $query->where('user_id', Auth::id());
            }])
            ->whereHas('club', function ($query) {
                $query->whereHas('clubMembers', function ($subQuery) {
                    $subQuery->where('user_id', Auth::id())
                             ->where('status', 'approved');
                });
            })
            ->orderBy('start_time', 'asc')
            ->get();

        return view('member.events.index', compact('events'));
    }

    public function register($id)
    {
        $event = Event::findOrFail($id);

        // Check if user is in the club for this event
        $isMember = \App\Models\ClubMember::where('club_id', $event->club_id)
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->exists();

        if (!$isMember) {
            return back()->with('error', 'Bạn phải là thành viên chính thức của câu lạc bộ này mới có thể đăng ký sự kiện.');
        }

        // Check if already registered
        $exists = \App\Models\Registration::where('event_id', $id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Bạn đã đăng ký tham gia sự kiện này rồi.');
        }

        // Check capacity if needed (add max_participants check here later)

        \App\Models\Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $id,
            'status' => 'approved',
            'registered_at' => now(),
        ]);

        return back()->with('success', 'Bạn đã tham gia sự kiện thành công! Hãy chuẩn bị tinh thần sẵn sàng nhé.');
    }
}