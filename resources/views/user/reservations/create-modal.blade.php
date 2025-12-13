<x-modal id="createReservation" title="Create reservation">
    <form method="POST" action="{{ route('user.reservations.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-slate-600 mb-1">Facility</label>
            <select name="facility_id" class="w-full rounded-lg border-slate-200">
                @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}">{{ $facility->name }} @unless($facility->is_active) (Inactive) @endunless</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm text-slate-600 mb-1">Start</label>
                <input type="datetime-local" name="start_time" class="w-full rounded-lg border-slate-200" required>
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">End</label>
                <input type="datetime-local" name="end_time" class="w-full rounded-lg border-slate-200" required>
            </div>
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Reason (optional)</label>
            <textarea name="reason" class="w-full rounded-lg border-slate-200" rows="3"></textarea>
        </div>
        @if ($errors->any())
            <div class="rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-sm p-3">
                <div class="font-semibold mb-1">Cannot book this slot</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2">Submit for approval</button>
    </form>
</x-modal>
