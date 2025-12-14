@extends('layouts.user')

@section('content')
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
        <div>
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-medium mb-2">
                🏢 Browse Facilities
            </span>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Available Facilities</h1>
            <p class="text-slate-600 mt-1">Choose a space and head to your calendar to book</p>
        </div>
        <a href="{{ route('user.reservations.index') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200 shadow-lg">
            📅 Open calendar
        </a>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($facilities as $facility)
            <div class="bg-white border border-slate-200 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                @if($facility->thumbnail_url)
                    <div class="relative overflow-hidden h-48">
                        <img src="{{ asset($facility->thumbnail_url) }}" alt="{{ $facility->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        <span class="absolute top-3 right-3 px-3 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
                            Active
                        </span>
                    </div>
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                @endif
                <div class="p-5 space-y-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 mb-2">{{ $facility->name }}</h2>
                        <p class="text-sm text-slate-600 line-clamp-2">{{ $facility->description }}</p>
                        @if($facility->location)
                            <div class="flex items-center gap-2 text-sm text-slate-500 mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $facility->location }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= ($facility->ratings_avg_rating ?? 0) ? 'text-amber-400' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm font-medium text-slate-900">{{ number_format($facility->ratings_avg_rating ?? 0, 1) }}</span>
                            <span class="text-xs text-slate-500">({{ $facility->ratings_count }} ratings)</span>
                        </div>
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                            {{ $facility->type ?? 'Facility' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <a href="{{ route('user.reservations.index') }}" 
                           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200">
                            Reserve now
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                        <a href="{{ route('user.reservations.index') }}#createReservation" 
                           class="inline-flex items-center justify-center gap-2 px-3 py-2.5 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 focus:ring-4 focus:ring-blue-100 transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </a>
                    </div>

                    <form method="POST" action="{{ route('user.facilities.ratings.store', $facility) }}" class="pt-4 border-t border-slate-100 space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Rate this facility</label>
                            <div class="flex items-center gap-2">
                                <select name="rating" 
                                        class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                                <span class="text-sm text-slate-500">(optional)</span>
                            </div>
                        </div>
                        <div>
                            <textarea name="comment" rows="2" 
                                      class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                                      placeholder="Leave a comment about your experience..."></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full px-4 py-2.5 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 focus:ring-4 focus:ring-blue-100 transition duration-200">
                            Submit rating
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16">
                <div class="text-slate-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">No facilities available</h3>
                <p class="text-slate-500">Check back later for available facilities.</p>
            </div>
        @endforelse
    </div>
@endsection