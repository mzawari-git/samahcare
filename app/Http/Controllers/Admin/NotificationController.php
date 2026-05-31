<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orWhereNull('user_id')
            ->orderByDesc('created_at')
            ->paginate(20);

        $unreadCount = Notification::whereNull('read_at')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())->orWhereNull('user_id');
            })
            ->count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function unread()
    {
        $notifications = Notification::whereNull('read_at')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())->orWhereNull('user_id');
            })
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count(),
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::whereNull('read_at')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())->orWhereNull('user_id');
            })
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true]);
    }
}
