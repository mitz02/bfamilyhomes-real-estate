<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->latest()
            ->paginate(20);

        return view('dashboard.notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $id)
    {
        try {
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notification as read',
            ], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            auth()->user()->notifications()->unread()->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notifications as read',
            ], 500);
        }
    }

    public function getUnreadCount()
    {
        $count = auth()->user()->unreadNotifications()->count();
        
        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    public function getRecent()
    {
        $notifications = auth()->user()->notifications()
            ->unread()
            ->recent(5)
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
        ]);
    }
}
