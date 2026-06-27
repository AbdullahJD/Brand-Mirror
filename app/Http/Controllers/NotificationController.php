<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);
        
        return view('Dashboard.notifications.index', [
            'notifications' => auth()->user()->notifications()->latest()->paginate(20)
        ]);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        $notification->update([
            'is_read' => true
        ]);

        return back();
    }

    public function markAll()
    {
        auth()->user()->notifications()->update([
            'is_read' => true
        ]);

        return back();
    }
}
