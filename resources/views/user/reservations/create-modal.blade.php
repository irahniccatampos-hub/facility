<x-modal id="createReservation" title="Create New Reservation">
    <form method="POST" action="{{ route('user.reservations.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block mb-2 text-sm font-medium text-slate-700">Select Facility *</label>
            <select name="facility_id" required
                    class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                <option value="">Choose a facility...</option>
                @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}" {{ !$facility->is_active ? 'disabled' : '' }}>
                        {{ $facility->name }}
                        @unless($facility->is_active)
                            (Currently unavailable)
                        @endunless
                    </option>
                @endforeach
            </select>
            <p class="mt-1 text-xs text-slate-500">Only active facilities can be booked</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">Start Date & Time *</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input type="datetime-local" name="start_time" required
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3">
                </div>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">End Date & Time *</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input type="datetime-local" name="end_time" required
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3">
                </div>
            </div>
        </div>
        
        <div>
            <label class="block mb-2 text-sm font-medium text-slate-700">Purpose / Reason (Optional)</label>
            <textarea name="reason" rows="3"
                      class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                      placeholder="Brief description of what this reservation is for..."></textarea>
            <p class="mt-1 text-xs text-slate-500">This helps admins understand your booking needs</p>
        </div>
        
        @if ($errors->any())
            <div class="rounded-xl bg-red-50 border border-red-200 p-4">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <h3 class="text-sm font-semibold text-red-800">Cannot book this time slot</h3>
                </div>
                <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="flex items-center justify-between pt-2">
            <div class="text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Requires admin approval
                </div>
            </div>
            <button type="submit"
                    class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200">
                Submit for Approval
            </button>
        </div>
    </form>
</x-modal>