@extends('layouts.admin')

@section('content')
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Facility Management</h1>
            <p class="text-slate-600 mt-1">Manage all facilities and their settings</p>
        </div>
        <div role="button" tabindex="0" data-modal-target="createFacility" data-modal-toggle="createFacility" 
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200 cursor-pointer">
            <span>+</span>
            <span>Add facility</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="text-xs uppercase text-slate-500 bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 font-medium">Thumbnail</th>
                        <th class="px-6 py-4 font-medium">Name</th>
                        <th class="px-6 py-4 font-medium">Location</th>
                        <th class="px-6 py-4 font-medium">Rating</th>
                        <th class="px-6 py-4 font-medium">Type</th>
                        <th class="px-6 py-4 font-medium">Coordinates</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $facility)
                        <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition duration-150">
                            <td class="px-6 py-4">
                                @if($facility->thumbnail_url)
                                    <img src="{{ asset($facility->thumbnail_url) }}" alt="{{ $facility->name }}" 
                                         class="w-16 h-12 rounded-lg object-cover border border-slate-200 shadow-sm">
                                @else
                                    <div class="w-16 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $facility->name }}</div>
                                <div class="text-xs text-slate-500 truncate max-w-xs">{{ $facility->description }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-700">{{ $facility->location }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center text-amber-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="ml-1 font-medium">{{ number_format($facility->ratings_avg_rating ?? 0, 1) }}</span>
                                    </div>
                                    <div class="text-xs text-slate-500">({{ $facility->ratings_count }})</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700">
                                    {{ $facility->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-slate-500 font-mono">
                                    {{ $facility->latitude }}, {{ $facility->longitude }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $facility->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $facility->is_active ? 'Active' : 'Disabled' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <div role="button" tabindex="0" data-modal-target="editFacility{{ $facility->id }}" data-modal-toggle="editFacility{{ $facility->id }}" 
                                            class="px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition duration-200 cursor-pointer">
                                        Edit
                                    </div>
                                    <form method="POST" action="{{ route('admin.facilities.destroy', $facility) }}" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to disable this facility?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" 
                                                value="Disable"
                                                class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition duration-200 cursor-pointer">
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <x-modal id="editFacility{{ $facility->id }}" title="Edit Facility">
                            <form method="POST" action="{{ route('admin.facilities.update', $facility) }}" enctype="multipart/form-data" class="space-y-5">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-slate-700">Facility Name</label>
                                    <input type="text" name="name" value="{{ $facility->name }}" 
                                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-slate-700">Location</label>
                                    <input type="text" name="location" value="{{ $facility->location }}" 
                                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-slate-700">Type</label>
                                        <input type="text" name="type" value="{{ $facility->type }}" 
                                               class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-slate-700">Latitude</label>
                                        <input type="text" name="latitude" value="{{ $facility->latitude }}" 
                                               class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-slate-700">Longitude</label>
                                        <input type="text" name="longitude" value="{{ $facility->longitude }}" 
                                               class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                                    </div>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-slate-700">Thumbnail URL</label>
                                    <input type="text" name="thumbnail_url" value="{{ $facility->thumbnail_url }}" 
                                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                                           placeholder="https://example.com/image.jpg">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-slate-700">Upload Thumbnail</label>
                                    <input type="file" name="thumbnail" 
                                           class="block w-full text-sm text-slate-900 border border-slate-200 rounded-lg cursor-pointer bg-slate-50 focus:outline-none">
                                    <p class="mt-1 text-xs text-slate-500">PNG, JPG, GIF up to 5MB</p>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-slate-700">Description</label>
                                    <textarea name="description" rows="3"
                                              class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">{{ $facility->description }}</textarea>
                                </div>
                                <div class="flex items-center">
                                    <input id="is_active{{ $facility->id }}" type="checkbox" name="is_active" value="1" 
                                           @checked($facility->is_active)
                                           class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="is_active{{ $facility->id }}" class="ml-2 text-sm text-slate-700">
                                        Active facility
                                    </label>
                                </div>
                                <input type="submit" 
                                        value="Save Changes"
                                        class="w-full text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3.5 text-center transition duration-200 cursor-pointer">
                            </form>
                        </x-modal>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-slate-400">
                                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-slate-500">No facilities created yet</p>
                                    <p class="text-sm text-slate-400 mt-1">Add your first facility to get started</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($facilities->count() > 0)
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    Showing <span class="font-medium">{{ $facilities->count() }}</span> facilities
                </div>
                <div class="text-xs text-slate-500">
                    Last updated {{ now()->format('M d, Y') }}
                </div>
            </div>
        </div>
        @endif
    </div>

    <x-modal id="createFacility" title="Add New Facility">
        <form method="POST" action="{{ route('admin.facilities.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">Facility Name *</label>
                <input type="text" name="name" required
                       class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">Location</label>
                <input type="text" name="location"
                       class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                       placeholder="Building, Floor, Room Number">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Type</label>
                    <input type="text" name="type"
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                           placeholder="e.g., Conference Room, Lab">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Latitude</label>
                    <input type="text" name="latitude"
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                           placeholder="6.75">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Longitude</label>
                    <input type="text" name="longitude"
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                           placeholder="125.35">
                </div>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">Thumbnail URL</label>
                <input type="text" name="thumbnail_url"
                       class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                       placeholder="https://example.com/facility-image.jpg">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">Upload Thumbnail</label>
                <input type="file" name="thumbnail"
                       class="block w-full text-sm text-slate-900 border border-slate-200 rounded-lg cursor-pointer bg-slate-50 focus:outline-none">
                <p class="mt-1 text-xs text-slate-500">PNG, JPG, GIF up to 5MB</p>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">Description</label>
                <textarea name="description" rows="3"
                          class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                          placeholder="Describe the facility features, capacity, equipment..."></textarea>
            </div>
            <div class="flex items-center">
                <input id="is_active" type="checkbox" name="is_active" value="1" checked
                       class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                <label for="is_active" class="ml-2 text-sm text-slate-700">
                    Activate facility immediately
                </label>
            </div>
            <input type="submit"
                    value="Create Facility"
                    class="w-full text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3.5 text-center transition duration-200 cursor-pointer">
        </form>
    </x-modal>
@endsection
