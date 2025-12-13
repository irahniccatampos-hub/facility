@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold text-slate-900">Facilities</h1>
        <button data-modal-target="createFacility" data-modal-toggle="createFacility" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add facility</button>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-slate-600">
                <thead class="text-xs uppercase bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Thumbnail</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Location</th>
                        <th class="px-4 py-3">Rating</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Lat / Lng</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $facility)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-3">
                                @if($facility->thumbnail_url)
                                    <img src="{{ asset($facility->thumbnail_url) }}" alt="{{ $facility->name }}" class="w-16 h-12 rounded object-cover border border-slate-100">
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $facility->name }}</td>
                            <td class="px-4 py-3">{{ $facility->location }}</td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-amber-600">★ {{ number_format($facility->ratings_avg_rating ?? 0, 1) }}</div>
                                <div class="text-xs text-slate-500">{{ $facility->ratings_count }} ratings</div>
                            </td>
                            <td class="px-4 py-3">{{ $facility->type }}</td>
                            <td class="px-4 py-3 text-xs text-slate-500">{{ $facility->latitude }}, {{ $facility->longitude }}</td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-xs rounded-full {{ $facility->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $facility->is_active ? 'Active' : 'Disabled' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button data-modal-target="editFacility{{ $facility->id }}" data-modal-toggle="editFacility{{ $facility->id }}" class="text-blue-600">Edit</button>
                                <form method="POST" action="{{ route('admin.facilities.destroy', $facility) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Disable</button>
                                </form>
                            </td>
                        </tr>

                        <x-modal id="editFacility{{ $facility->id }}" title="Edit facility">
                            <form method="POST" action="{{ route('admin.facilities.update', $facility) }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1">Name</label>
                                    <input type="text" name="name" value="{{ $facility->name }}" class="w-full rounded-lg border-slate-200" required>
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1">Location</label>
                                    <input type="text" name="location" value="{{ $facility->location }}" class="w-full rounded-lg border-slate-200">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm text-slate-600 mb-1">Type</label>
                                        <input type="text" name="type" value="{{ $facility->type }}" class="w-full rounded-lg border-slate-200">
                                    </div>
                                    <div>
                                        <label class="block text-sm text-slate-600 mb-1">Latitude</label>
                                        <input type="text" name="latitude" value="{{ $facility->latitude }}" class="w-full rounded-lg border-slate-200">
                                    </div>
                                    <div>
                                        <label class="block text-sm text-slate-600 mb-1">Longitude</label>
                                        <input type="text" name="longitude" value="{{ $facility->longitude }}" class="w-full rounded-lg border-slate-200">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1">Thumbnail URL</label>
                                    <input type="text" name="thumbnail_url" value="{{ $facility->thumbnail_url }}" class="w-full rounded-lg border-slate-200" placeholder="https://... or use upload below">
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1">Upload thumbnail</label>
                                    <input type="file" name="thumbnail" class="w-full text-sm text-slate-600">
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1">Description</label>
                                    <textarea name="description" class="w-full rounded-lg border-slate-200" rows="3">{{ $facility->description }}</textarea>
                                </div>
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="checkbox" name="is_active" value="1" @checked($facility->is_active) class="rounded">
                                    Active
                                </label>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2">Save</button>
                            </form>
                        </x-modal>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-slate-600">No facilities created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-modal id="createFacility" title="Add facility">
        <form method="POST" action="{{ route('admin.facilities.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-slate-600 mb-1">Name</label>
                <input type="text" name="name" class="w-full rounded-lg border-slate-200" required>
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Location</label>
                <input type="text" name="location" class="w-full rounded-lg border-slate-200">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Type</label>
                    <input type="text" name="type" class="w-full rounded-lg border-slate-200">
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Latitude</label>
                    <input type="text" name="latitude" class="w-full rounded-lg border-slate-200" placeholder="6.75">
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Longitude</label>
                    <input type="text" name="longitude" class="w-full rounded-lg border-slate-200" placeholder="125.35">
                </div>
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Thumbnail URL</label>
                <input type="text" name="thumbnail_url" class="w-full rounded-lg border-slate-200" placeholder="https://... or use upload below">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Upload thumbnail</label>
                <input type="file" name="thumbnail" class="w-full text-sm text-slate-600">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Description</label>
                <textarea name="description" class="w-full rounded-lg border-slate-200" rows="3"></textarea>
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_active" value="1" checked class="rounded">
                Active
            </label>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2">Create</button>
        </form>
    </x-modal>
@endsection
