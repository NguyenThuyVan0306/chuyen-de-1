<?php

namespace App\Http\Controllers;

use App\Models\ClubMember;
use Illuminate\Http\Request;

class AdminClubMemberController extends Controller
{
    /**
     * Hiển thị danh sách tất cả thành viên của các câu lạc bộ (Chế độ xem duy nhất cho Admin).
     */
    public function index()
    {
        $members = ClubMember::with(['user', 'club'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.club_members.index', compact('members'));
    }

    // Ghi chú: Chức năng Duyệt/Từ chối đã được chuyển giao cho Leader của từng Câu lạc bộ.
    // Admin chỉ giữ vai trò giám sát danh sách tổng thể.
}