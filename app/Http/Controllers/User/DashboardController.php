<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pending = $user->reservations()->where('status', Reservation::STATUS_PENDING)->count();
        $approved = $user->reservations()->where('status', Reservation::STATUS_APPROVED)->count();
        $upcoming = $user->reservations()
            ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_APPROVED])
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        return view('user.dashboard', [
            'pending' => $pending,
            'approved' => $approved,
            'upcoming' => $upcoming,
        ]);
    }
}
