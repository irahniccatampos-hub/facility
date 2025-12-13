<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index()
    {
        $pending = Reservation::where('status', Reservation::STATUS_PENDING)->count();
        $approved = Reservation::where('status', Reservation::STATUS_APPROVED)->count();
        $facilities = Facility::count();

        $upcoming = Reservation::with(['facility', 'user'])
            ->where('status', Reservation::STATUS_APPROVED)
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        $notifications = auth()->user()?->notifications()->latest()->limit(5)->get() ?? collect();

        return view('admin.dashboard', compact('pending', 'approved', 'facilities', 'upcoming', 'notifications'));
    }
}
