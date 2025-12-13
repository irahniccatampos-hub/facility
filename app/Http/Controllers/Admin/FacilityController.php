<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FacilityController extends Controller
{
    public function index(): View
    {
        $facilities = Facility::withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderBy('name')
            ->get();

        return view('admin.facilities.index', compact('facilities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'thumbnail_url' => ['nullable', 'url'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $thumbnailUrl = $data['thumbnail_url'] ?? null;
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/facilities'), $filename);
            $thumbnailUrl = asset('images/facilities/' . $filename);
        }

        Facility::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'location' => $data['location'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'thumbnail_url' => $thumbnailUrl,
            'type' => $data['type'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);

        return back()->with('status', 'Facility created.');
    }

    public function update(Request $request, Facility $facility): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'thumbnail_url' => ['nullable', 'url'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $thumbnailUrl = $data['thumbnail_url'] ?? $facility->thumbnail_url;
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/facilities'), $filename);
            $thumbnailUrl = asset('images/facilities/' . $filename);
        }

        $facility->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'location' => $data['location'] ?? null,
            'is_active' => $data['is_active'] ?? $facility->is_active,
            'thumbnail_url' => $thumbnailUrl,
            'type' => $data['type'] ?? $facility->type,
            'latitude' => $data['latitude'] ?? $facility->latitude,
            'longitude' => $data['longitude'] ?? $facility->longitude,
        ]);

        return back()->with('status', 'Facility updated.');
    }

    public function destroy(Facility $facility): RedirectResponse
    {
        $facility->update(['is_active' => false]);

        return back()->with('status', 'Facility disabled.');
    }
}
