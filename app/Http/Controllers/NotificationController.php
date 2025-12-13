<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $notifications = $user->notifications()->latest()->limit(10)->get()->map(fn ($note) => [
            'id' => $note->id,
            'title' => $note->data['title'] ?? 'Update',
            'message' => $note->data['message'] ?? '',
            'created_at' => $note->created_at->toDateTimeString(),
            'read_at' => $note->read_at?->toDateTimeString(),
        ]);

        $unread = $user->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread' => $unread,
        ]);
    }

    public function markRead(Request $request): JsonResponse
    {
        $ids = $request->input('ids', []);
        $request->user()->unreadNotifications()->whereIn('id', $ids)->update(['read_at' => now()]);

        return response()->json(['status' => 'ok']);
    }
}
