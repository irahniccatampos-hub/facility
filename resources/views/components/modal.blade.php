@props(['id', 'title'])

<div id="{{ $id }}" tabindex="-1" aria-hidden="true" 
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full mx-auto flex items-center min-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full">
            <div class="flex items-center justify-between p-6 border-b border-slate-100 rounded-t-2xl">
                <h3 class="text-xl font-bold text-slate-900">
                    {{ $title }}
                </h3>
                <div role="button" tabindex="0"
                        class="text-slate-400 hover:text-slate-900 rounded-lg text-sm p-2 hover:bg-slate-100 transition duration-200 cursor-pointer"
                        data-modal-hide="{{ $id }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </div>
            </div>
            <div class="p-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
