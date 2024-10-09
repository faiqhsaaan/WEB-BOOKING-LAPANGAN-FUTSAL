<?php

namespace App\Http\Controllers;

use App\Models\notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications;
        return view('dashboard.notifications.index', compact('notifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'minutes_before' => 'required|integer|min:1|max:10080',
        ]);

        auth()->user()->notifications()->create([
            'minutes_before' => $request->minutes_before,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Notifikasi baru berhasil ditambahkan.');
    }

    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'minutes_before' => 'required|integer|min:1|max:10080',
        ]);

        $notification->update([
            'minutes_before' => $request->minutes_before,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Notifikasi berhasil diperbarui.');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(['success' => true]);
    }
}
