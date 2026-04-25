<?php

namespace App\Http\Controllers;

use App\Models\Club;

class LandingPageController extends Controller
{
    public function index()
    {
        $clubs = Club::where('status', 'approved')
            ->withCount(['clubMembers as approved_count' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('welcome', compact('clubs'));
    }
}
