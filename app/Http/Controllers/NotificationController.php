<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $notifications = $user?->notifications()
            ->latest()
            ->limit(20)
            ->get()
            ->map(fn ($n) => [
                'id' => $n->id,
                'data' => $n->data,
                'read_at' => $n->read_at,
                'created_at' => $n->created_at,
                'created_human' => optional($n->created_at)->diffForHumans(),
            ]);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $user?->unreadNotifications()->count() ?? 0,
        ]);
    }

    public function readAll(): JsonResponse
    {
        $user = Auth::user();

        $user?->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['status' => 'ok']);
    }

    public function read(string $id): JsonResponse
    {
        $user = Auth::user();

        $notification = $user?->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->update(['read_at' => now()]);
        }

        return response()->json(['status' => 'ok']);
    }
}
