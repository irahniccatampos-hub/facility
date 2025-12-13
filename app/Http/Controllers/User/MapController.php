<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\View\View;

class MapController extends Controller
{
    public function index(): View
    {
        $facilities = Facility::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('is_active', true)
            ->select('id', 'name', 'location', 'type', 'latitude', 'longitude')
            ->get();

        return view('user.facilities.map', [
            'facilities' => $facilities,
            'center' => ['lat' => 6.7497, 'lng' => 125.3572],
        ]);
    }
}
