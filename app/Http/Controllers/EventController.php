<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('club')->orderBy('id', 'desc')->get();
        $clubs = Club::orderBy('id', 'desc')->get();

        return view('admin.events.index', compact('events', 'clubs'));
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        if (!empty($event->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($event->image);
        }
        
        $event->delete(); 

        return redirect()->route('admin.events.index')->with('success', 'Xóa sự kiện thành công');
    }
}