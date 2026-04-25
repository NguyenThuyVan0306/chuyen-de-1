<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use Illuminate\Support\Facades\Auth;

class MemberClubController extends Controller
{

    public function index()
    {
        $clubs = Club::with([
            'clubMembers' => function ($query) {
                $query->where('user_id', Auth::id());
            }
        ])
        ->withCount([
            'clubMembers as approved_count' => function ($query) {
                $query->where('status', 'approved');
            }
        ])
        ->whereDoesntHave('clubMembers', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'approved');
        })
        ->orderBy('id', 'desc')
        ->paginate(6);

        return view('member.clubs.index', compact('clubs'));
    }

    public function myClubs()
    {
        $clubs = Club::whereHas('clubMembers', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'approved');
        })
        ->withCount([
            'clubMembers as approved_count' => function ($query) {
                $query->where('status', 'approved');
            }
        ])
        ->orderBy('id', 'desc')
        ->paginate(6);

        return view('member.myclubs.index', compact('clubs'));
    }
    public function join(\Illuminate\Http\Request $request, $id)
    {
        $club = Club::findOrFail($id);

        $exists = ClubMember::where('club_id', $club->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($exists) {
            return redirect()->route('member.clubs.index')
                ->with('error', 'Bạn đã gửi yêu cầu hoặc đã tham gia câu lạc bộ này.');
        }

        // Cập nhật Khoa/Lớp cho User nếu được gửi lên và cột tồn tại trong DB
        if ($request->faculty && \Illuminate\Support\Facades\Schema::hasColumn('users', 'faculty')) {
            if (!Auth::user()->faculty) {
                Auth::user()->update(['faculty' => $request->faculty]);
            }
        }

        // Chuẩn bị dữ liệu nộp đơn an toàn
        $memberData = [
            'club_id' => $club->id,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ];

        // Chỉ thêm trường 'reason' nếu cột này đã tồn tại trong database
        if ($request->reason && \Illuminate\Support\Facades\Schema::hasColumn('club_members', 'reason')) {
            $memberData['reason'] = $request->reason;
        }

        ClubMember::create($memberData);

        return redirect()->route('member.clubs.index')
            ->with('success', 'Gửi yêu cầu tham gia câu lạc bộ thành công.');
    }

    public function leave($id)
    {
        $club = Club::findOrFail($id);

        $membership = ClubMember::where('club_id', $club->getKey())
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->first();

        if (!$membership) {
            return redirect()->route('member.clubs.index')
                ->with('error', 'Bạn chưa là thành viên chính thức của câu lạc bộ này.');
        }

        $membership->delete();

        return redirect()->route('member.clubs.index')
            ->with('success', 'Bạn đã rời câu lạc bộ thành công.');
    }
}