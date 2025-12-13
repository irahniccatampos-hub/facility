<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReservationAnalyticsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function __construct(private readonly ReservationAnalyticsService $analyticsService)
    {
    }

    public function index(): View
    {
        return view('admin.analytics.index');
    }

    public function facilityUsage(): JsonResponse
    {
        [$from, $to] = $this->resolveDateRange();

        return response()->json($this->analyticsService->facilityUsage($from, $to));
    }

    public function peakHours(): JsonResponse
    {
        [$from, $to] = $this->resolveDateRange();

        return response()->json($this->analyticsService->peakHours($from, $to));
    }

    private function resolveDateRange(): array
    {
        $from = request('from') ? Carbon::parse(request('from'))->utc() : null;
        $to = request('to') ? Carbon::parse(request('to'))->utc() : null;

        return [$from, $to];
    }
}
