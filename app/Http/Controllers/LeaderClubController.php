<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderClubController extends Controller
{
    public function membersIndex(Request $request)
    {
        // Lấy tất cả CLB mà user quản lý
        $allClubs = Club::where('user_id', Auth::id())->where('status', 'approved')->get();
        
        if ($allClubs->isEmpty()) {
            return redirect()->route('leader.home')->with('error', 'Bạn chưa quản lý câu lạc bộ nào hoặc CLB chưa được duyệt.');
        }

        // Ưu tiên chọn club_id từ request. Nếu trống = "Tất cả"
        $clubId = $request->input('club_id');
        $isAll = empty($clubId);
        
        if ($isAll) {
            $club = null; // Đại diện cho "Tất cả"
            $clubIds = $allClubs->pluck('id');
            $maxMembers = $allClubs->sum('max_members');
        } else {
            $club = $allClubs->where('id', $clubId)->first();
            if (!$club) {
                // Nếu ID không hợp lệ, quay về mặc định CLB đầu tiên hoặc báo lỗi
                $club = $allClubs->first();
                $clubId = $club->id;
            }
            $clubIds = [$club->id];
            $maxMembers = $club->max_members;
        }

        $search = $request->input('search');
        $department = $request->input('department');

        // Query cho Thành viên chính thức
        $membersQuery = \App\Models\ClubMember::with(['user', 'club'])
            ->whereIn('club_id', $clubIds)
            ->where('status', 'approved');

        if ($search) {
            $membersQuery->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($department) {
            $membersQuery->where('department', $department);
        }

        $members = $membersQuery->get();

        // Query cho Yêu cầu chờ duyệt
        $pendingRequests = \App\Models\ClubMember::with(['user', 'club'])
            ->whereIn('club_id', $clubIds)
            ->where('status', 'pending')
            ->get();

        return view('leader.members.index', compact('club', 'allClubs', 'members', 'pendingRequests', 'isAll', 'maxMembers'));
    }

    public function eventsIndex(Request $request)
    {
        $allClubs = Club::where('user_id', Auth::id())->where('status', 'approved')->get();
        
        if ($allClubs->isEmpty()) {
            return redirect()->route('leader.home')->with('error', 'Bạn chưa quản lý câu lạc bộ nào.');
        }

        $clubId = $request->input('club_id');
        $isAll = empty($clubId);

        if ($isAll) {
            $club = null;
            $clubIds = $allClubs->pluck('id');
        } else {
            $club = $allClubs->where('id', $clubId)->first();
            if (!$club) {
                $club = $allClubs->first();
                $clubId = $club->id;
            }
            $clubIds = [$club->id];
        }

        $events = \App\Models\Event::with('club')
            ->whereIn('club_id', $clubIds)
            ->latest()
            ->get();

        return view('leader.events.index', compact('club', 'allClubs', 'events', 'isAll'));
    }

    public function infoIndex(Request $request)
    {
        $allClubs = Club::where('user_id', Auth::id())->get(); // Lấy tất cả, kể cả pending để leader có thể xem/sửa
        
        if ($allClubs->isEmpty()) {
            // Nếu chưa có CLB nào, vẫn cho vào trang quản lý để "Tạo mới"
            $club = null;
        } else {
            $clubId = $request->input('club_id');
            $club = $clubId ? $allClubs->where('id', $clubId)->first() : $allClubs->first();
            if (!$club) $club = $allClubs->first();
        }

        return view('leader.clubs.info', compact('club', 'allClubs'));
    }

    public function update(Request $request, $id)
    {
        $club = Club::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $club->image;
        if ($request->hasFile('image')) {
            if ($club->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($club->image);
            }
            $imagePath = $request->file('image')->store('club-images', 'public');
        }

        $club->update([
            'name' => $request->name,
            'description' => $request->description,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Cập nhật thông tin Câu lạc bộ thành công.');
    }

    public function create()
    {
        return view('leader.clubs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|max:20',
            'max_members' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('club-images', 'public');
        }

        Club::create([
            'user_id' => Auth::id(), // Gắn người xin lập là chủ nhiệm
            'name' => $request->name,
            'description' => $request->description,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'max_members' => $request->max_members,
            'image' => $imagePath,
            'status' => 'pending', // Phải đợi Admin duyệt
        ]);

        return redirect()->route('leader.home')->with('success', 'Đã gửi yêu cầu lập Câu lạc bộ thành công! Bạn có thể theo dõi trạng thái "ĐANG CHỜ" ngay tại bảng "Câu lạc bộ đang quản lý" phía dưới.');
    }

    public function manage(Request $request, $id)
    {
        $club = Club::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $search = $request->input('search');
        $department = $request->input('department');

        // Query cho Thành viên chính thức
        $membersQuery = \App\Models\ClubMember::with('user')
            ->where('club_id', $club->id)
            ->where('status', 'approved');

        if ($search) {
            $membersQuery->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($department) {
            $membersQuery->where('department', $department);
        }

        $members = $membersQuery->get();

        // Query cho Yêu cầu chờ duyệt
        $pendingRequests = \App\Models\ClubMember::with('user')
            ->where('club_id', $club->id)
            ->where('status', 'pending')
            ->get();

        // Events
        $events = \App\Models\Event::where('club_id', $club->id)->get();

        return view('leader.clubs.manage', compact('club', 'members', 'pendingRequests', 'events'));
    }

    public function approveMember($id)
    {
        $member = \App\Models\ClubMember::findOrFail($id);
        $club = Club::findOrFail($member->club_id);

        // Check ownership
        if ($club->user_id !== Auth::id()) {
            return back()->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        // Check max members
        $currentCount = \App\Models\ClubMember::where('club_id', $club->id)
            ->where('status', 'approved')
            ->count();
        
        if ($currentCount >= $club->max_members) {
            return back()->with('error', 'Câu lạc bộ đã đạt giới hạn thành viên tối đa.');
        }

        $member->update([
            'status' => 'approved',
            'joined_at' => now(),
        ]);

        return back()->with('success', 'Đã duyệt thành viên thành công.');
    }

    public function rejectMember($id)
    {
        $member = \App\Models\ClubMember::findOrFail($id);
        $club = Club::findOrFail($member->club_id);

        if ($club->user_id !== Auth::id()) {
            return back()->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        $member->update(['status' => 'rejected']);

        return back()->with('success', 'Đã từ chối yêu cầu tham gia.');
    }

    public function removeMember($id)
    {
        $member = \App\Models\ClubMember::findOrFail($id);
        $club = Club::findOrFail($member->club_id);

        if ($club->user_id !== Auth::id()) {
            return back()->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        $member->delete();

        return back()->with('success', 'Đã xóa thành viên khỏi câu lạc bộ.');
    }

    // --- EVENT CRUD METHODS FOR LEADER ---

    public function storeEvent(Request $request)
    {
        $request->validate([
            'club_id' => 'required|exists:clubs,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Kiểm tra quyền sở hữu CLB
        $club = Club::where('id', $request->club_id)->where('user_id', Auth::id())->firstOrFail();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event-images', 'public');
        }

        // Tính toán status để lưu vào DB (đồng bộ với Calculated Status)
        $now = now();
        $startTime = \Carbon\Carbon::parse($request->start_time);
        $endTime = \Carbon\Carbon::parse($request->end_time);
        $dbStatus = 'upcoming';
        if ($now->between($startTime, $endTime)) {
            $dbStatus = 'ongoing';
        } elseif ($now->gt($endTime)) {
            $dbStatus = 'finished';
        }

        \App\Models\Event::create([
            'club_id' => $club->id,
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'status' => $dbStatus,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Đã tạo sự kiện mới thành công.');
    }

    public function updateEvent(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $club = Club::where('id', $event->club_id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $event->image;
        if ($request->hasFile('image')) {
            if ($event->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('image')->store('event-images', 'public');
        }

        // Tính toán status để lưu vào DB
        $now = now();
        $startTime = \Carbon\Carbon::parse($request->start_time);
        $endTime = \Carbon\Carbon::parse($request->end_time);
        $dbStatus = 'upcoming';
        if ($now->between($startTime, $endTime)) {
            $dbStatus = 'ongoing';
        } elseif ($now->gt($endTime)) {
            $dbStatus = 'finished';
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'status' => $dbStatus,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Cập nhật thông tin sự kiện thành công.');
    }

    public function deleteEvent($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $club = Club::where('id', $event->club_id)->where('user_id', Auth::id())->firstOrFail();

        if ($event->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return back()->with('success', 'Đã xóa sự kiện thành công.');
    }

    public function eventParticipants($id)
    {
        $event = \App\Models\Event::with('club')->findOrFail($id);
        
        // Kiểm tra xem Leader có quản lý CLB của sự kiện này không
        $club = Club::where('id', $event->club_id)->where('user_id', Auth::id())->first();
        if (!$club) {
            return redirect()->route('leader.events.index')->with('error', 'Bạn không có quyền xem danh sách tham gia của sự kiện này.');
        }

        // Lấy danh sách đăng ký kèm thông tin user và thông tin ClubMember (để lấy MSSV, Khoa...)
        $participants = \App\Models\Registration::with(['user.clubMembers' => function($query) use ($event) {
                $query->where('club_id', $event->club_id);
            }])
            ->where('event_id', $id)
            ->where('status', 'approved')
            ->get();

        return view('leader.events.participants', compact('event', 'participants'));
    }
}
