<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Facility;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\ReservationSubmittedNotification;
use App\Services\ReservationConflictService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function __construct(private readonly ReservationConflictService $conflictService)
    {
    }

    public function index(): View
    {
        $facilities = Facility::where('is_active', true)->orderBy('name')->get();

        return view('user.reservations.calendar', compact('facilities'));
    }

    public function events(): JsonResponse
    {
        $events = Reservation::with('facility')
            ->where('user_id', Auth::id())
            ->orderBy('start_time')
            ->get()
            ->map(fn (Reservation $reservation) => [
                'id' => $reservation->id,
                'title' => $reservation->facility?->name ?? 'Reservation',
                'start' => $reservation->start_time,
                'end' => $reservation->end_time,
                'status' => $reservation->status,
            ]);

        return response()->json($events);
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $facility = Facility::findOrFail($data['facility_id']);

        $this->authorize('create', [Reservation::class, $facility]);

        $start = Carbon::parse($data['start_time'])->utc();
        $end = Carbon::parse($data['end_time'])->utc();

        // Block overlapping approved and pending requests to reduce collisions.
        if ($this->conflictService->hasConflict(
            $facility->id,
            $start,
            $end,
            null,
            [Reservation::STATUS_APPROVED, Reservation::STATUS_PENDING]
        )) {
            return back()->withErrors([
                'start_time' => 'This time slot is already reserved or awaiting approval. Please choose another slot.',
            ])->withInput();
        }

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'facility_id' => $facility->id,
            'start_time' => $start,
            'end_time' => $end,
            'status' => Reservation::STATUS_PENDING,
            'reason' => $data['reason'] ?? null,
        ]);
        $reservation->load(['facility', 'user']);

        // Notify admins, avoid duplicates by targeting unread latest
        $admins = User::where('role', User::ROLE_ADMIN)->get();
        Notification::send($admins, new ReservationSubmittedNotification($reservation));

        return back()->with('status', 'Reservation submitted for approval.');
    }

    public function update(StoreReservationRequest $request, Reservation $reservation): RedirectResponse
    {
        $this->authorize('update', $reservation);
        $data = $request->validated();
        $facility = Facility::findOrFail($data['facility_id']);

        $this->authorize('create', [Reservation::class, $facility]);

        $start = Carbon::parse($data['start_time'])->utc();
        $end = Carbon::parse($data['end_time'])->utc();

        if ($this->conflictService->hasConflict(
            $facility->id,
            $start,
            $end,
            $reservation->id,
            [Reservation::STATUS_APPROVED, Reservation::STATUS_PENDING]
        )) {
            return back()->withErrors([
                'start_time' => 'This time slot is already reserved or awaiting approval. Please choose another slot.',
            ])->withInput();
        }

        $reservation->update([
            'facility_id' => $facility->id,
            'start_time' => $start,
            'end_time' => $end,
            'reason' => $data['reason'] ?? null,
        ]);

        return back()->with('status', 'Reservation updated.');
    }

    public function destroy(Reservation $reservation): RedirectResponse
    {
        $this->authorize('cancel', $reservation);
        $reservation->update(['status' => Reservation::STATUS_CANCELLED]);

        return back()->with('status', 'Reservation cancelled.');
    }
}
