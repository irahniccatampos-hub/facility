<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\View\View;

class FacilityBrowseController extends Controller
{
    public function index(): View
    {
        $facilities = Facility::where('is_active', true)
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderBy('name')
            ->get();

        return view('user.facilities.index', compact('facilities'));
    }
}
