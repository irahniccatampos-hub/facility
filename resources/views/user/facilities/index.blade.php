@extends('layouts.user')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm text-blue-600 font-semibold uppercase tracking-wide">Browse</p>
            <h1 class="text-2xl font-semibold text-slate-900">Available Facilities</h1>
            <p class="text-slate-600">Choose a space and head to your calendar to book.</p>
        </div>
        <a href="{{ route('user.reservations.index') }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Open calendar</a>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($facilities as $facility)
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                @if($facility->thumbnail_url)
                    <img src="{{ asset($facility->thumbnail_url) }}" alt="{{ $facility->name }}" class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-slate-100 flex items-center justify-center text-slate-500">No image</div>
                @endif
                <div class="p-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">{{ $facility->name }}</h2>
                        <span class="px-3 py-1 text-xs rounded-full bg-emerald-50 text-emerald-700">Active</span>
                    </div>
                    <p class="text-sm text-slate-600">{{ $facility->description }}</p>
                    @if($facility->location)
                        <div class="text-sm text-slate-500">Location: {{ $facility->location }}</div>
                    @endif
                    <div class="flex items-center gap-2 text-sm text-amber-600">
                        <span>★ {{ number_format($facility->ratings_avg_rating ?? 0, 1) }}</span>
                        <span class="text-slate-500">({{ $facility->ratings_count }} ratings)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('user.reservations.index') }}" class="inline-flex items-center gap-2 text-blue-600 text-sm font-semibold">
                            Reserve now
                            <span aria-hidden="true">→</span>
                        </a>
                        <a href="{{ route('user.reservations.index') }}#createReservation" class="inline-flex items-center gap-2 text-slate-600 text-sm">
                            Quick book
                            <span aria-hidden="true">+</span>
                        </a>
                    </div>
                    <form method="POST" action="{{ route('user.facilities.ratings.store', $facility) }}" class="mt-3 space-y-2">
                        @csrf
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-slate-600">Rate:</label>
                            <select name="rating" class="rounded border-slate-200 text-sm">
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <textarea name="comment" rows="2" class="w-full rounded border-slate-200 text-sm" placeholder="Leave a comment (optional)"></textarea>
                        <button type="submit" class="w-full text-sm px-3 py-2 rounded-lg border border-slate-200 text-slate-800 hover:bg-slate-100">Submit rating</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-slate-600">No facilities available.</p>
        @endforelse
    </div>
@endsection
