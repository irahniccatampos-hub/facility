<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\ReservationConflictService;
use App\Notifications\ReservationStatusChangedNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class ReservationApprovalController extends Controller
{
    public function __construct(private readonly ReservationConflictService $conflictService)
    {
    }

    public function calendar(): View
    {
        return view('admin.reservations.calendar');
    }

    public function index(): View
    {
        $pending = Reservation::with(['facility', 'user'])
            ->where('status', Reservation::STATUS_PENDING)
            ->orderBy('start_time')
            ->get();

        return view('admin.reservations.approvals', compact('pending'));
    }

    public function approve(int $id): RedirectResponse
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('approve', $reservation);

        $start = Carbon::parse($reservation->start_time)->utc();
        $end = Carbon::parse($reservation->end_time)->utc();

        if ($this->conflictService->hasConflict($reservation->facility_id, $start, $end, $reservation->id)) {
            return back()->withErrors([
                'reservation' => 'This reservation conflicts with an existing approved booking.',
            ]);
        }

        if (!$reservation->isPending()) {
            return back()->withErrors(['reservation' => 'Only pending reservations can be approved.']);
        }

        $reservation->update(['status' => Reservation::STATUS_APPROVED]);
        Notification::send($reservation->user, new ReservationStatusChangedNotification($reservation));

        return back()->with('status', 'Reservation approved.');
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('approve', $reservation);

        if (!$reservation->isPending()) {
            return back()->withErrors(['reservation' => 'Only pending reservations can be rejected.']);
        }

        $reservation->update([
            'status' => Reservation::STATUS_REJECTED,
            'reason' => $request->input('reason'),
        ]);
        Notification::send($reservation->user, new ReservationStatusChangedNotification($reservation));

        return back()->with('status', 'Reservation rejected.');
    }

    public function cancel(int $id): RedirectResponse
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('cancel', $reservation);

        $reservation->update(['status' => Reservation::STATUS_CANCELLED]);
        Notification::send($reservation->user, new ReservationStatusChangedNotification($reservation));

        return back()->with('status', 'Reservation cancelled.');
    }

    public function events(): JsonResponse
    {
        $events = Reservation::with(['facility', 'user'])
            ->orderBy('start_time')
            ->get()
            ->map(fn (Reservation $reservation) => [
                'id' => $reservation->id,
                'title' => ($reservation->facility?->name ?? 'Reservation') . ' - ' . ($reservation->user?->name ?? 'User'),
                'start' => $reservation->start_time,
                'end' => $reservation->end_time,
                'status' => $reservation->status,
            ]);

        return response()->json($events);
    }
}
