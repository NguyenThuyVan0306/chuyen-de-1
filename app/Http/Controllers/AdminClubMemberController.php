<?php

namespace App\Http\Controllers;

use App\Models\ClubMember;
use Illuminate\Http\Request;

class AdminClubMemberController extends Controller
{

    public function index()
    {
        $members = ClubMember::with(['user', 'club'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.club_members.index', compact('members'));
    }

}