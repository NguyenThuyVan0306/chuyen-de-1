<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    public function index(Request $request)
    {
        $query = Club::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Tách thành 2 danh sách
        $pendingClubs = (clone $query)->whereIn('status', ['pending', 'rejected'])->orderBy('id', 'desc')->get();
        $activeClubs = (clone $query)->where('status', 'approved')->orderBy('id', 'desc')->get();

        $leaders = \App\Models\User::where('role', 'leader')->get();
        return view('admin.clubs.index', compact('pendingClubs', 'activeClubs', 'leaders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|max:255',
            'description' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|max:20',
            'max_members' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên câu lạc bộ',
            'description.required' => 'Vui lòng nhập mô tả',
            'contact_email.required' => 'Vui lòng nhập email liên hệ',
            'contact_email.email' => 'Email không đúng định dạng',
            'contact_phone.required' => 'Vui lòng nhập số điện thoại',
            'max_members.required' => 'Vui lòng nhập giới hạn thành viên',
            'max_members.integer' => 'Giới hạn thành viên phải là số',
            'max_members.min' => 'Giới hạn thành viên phải lớn hơn 0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Lưu vào storage/app/public/club-images/...
            $imagePath = $request->file('image')->store('club-images', 'public');
        }

        Club::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'max_members' => $request->max_members,
            'image' => $imagePath,
            'status' => 'approved',
        ]);

        return redirect()->route('admin.clubs.index')->with('success', 'Thêm câu lạc bộ thành công');
    }

    public function edit(Request $request, $id)
    {
        $query = Club::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $pendingClubs = (clone $query)->whereIn('status', ['pending', 'rejected'])->orderBy('id', 'desc')->get();
        $activeClubs = (clone $query)->where('status', 'approved')->orderBy('id', 'desc')->get();

        $editClub = Club::findOrFail($id);
        $leaders = \App\Models\User::where('role', 'leader')->get();

        return view('admin.clubs.index', compact('pendingClubs', 'activeClubs', 'editClub', 'leaders'));
    }

    public function update(Request $request, $id)
    {
        $club = Club::findOrFail($id);

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|max:255',
            'description' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|max:20',
            'max_members' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên câu lạc bộ',
            'description.required' => 'Vui lòng nhập mô tả',
            'contact_email.required' => 'Vui lòng nhập email liên hệ',
            'contact_email.email' => 'Email không đúng định dạng',
            'contact_phone.required' => 'Vui lòng nhập số điện thoại',
             'max_members.required' => 'Vui lòng nhập giới hạn thành viên',
            'max_members.integer' => 'Giới hạn thành viên phải là số',
            'max_members.min' => 'Giới hạn thành viên phải lớn hơn 0',
        ]);

        $imagePath = $club->image;
        if ($request->hasFile('image')) {
            if (!empty($club->image)) {
                Storage::disk('public')->delete($club->image);
            }
            $imagePath = $request->file('image')->store('club-images', 'public');
        }

        $club->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'max_members' => $request->max_members,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.clubs.index')->with('success', 'Cập nhật câu lạc bộ thành công');
    }

    public function show($id)
    {
        $club = Club::with(['leader', 'clubMembers.user'])->findOrFail($id);
        return view('admin.clubs.show', compact('club'));
    }

    public function approve($id)
    {
        $club = Club::findOrFail($id);
        $club->update(['status' => 'approved']);
        return back()->with('success', 'Đã duyệt Câu lạc bộ thành công.');
    }

    public function reject($id)
    {
        $club = Club::findOrFail($id);
        $club->update(['status' => 'rejected']);
        return back()->with('info', 'Đã từ chối yêu cầu thành lập Câu lạc bộ.');
    }

    public function destroy($id)
    {
        $club = Club::findOrFail($id);

        if (!empty($club->image)) {
            Storage::disk('public')->delete($club->image);
        }

        // Delete related members and events first or rely on cascade
        $club->delete();

        return redirect()->route('admin.clubs.index')->with('success', 'Xóa câu lạc bộ thành công');
    }
}