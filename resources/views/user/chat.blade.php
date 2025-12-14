@extends('layouts.user')

@section('content')
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">IrahKun Assistant</h1>
            <p class="text-slate-600 mt-1">Chat with your AI assistant for facility reservations</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-medium px-3 py-1 rounded-full bg-blue-100 text-blue-800">AI Assistant</span>
            <span class="text-xs font-medium px-3 py-1 rounded-full bg-emerald-100 text-emerald-800">Live</span>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">
                    IK
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">IrahKun Assistant</h2>
                    <p class="text-blue-100 text-sm">Ask about facilities, check conflicts, and get recommendations</p>
                </div>
            </div>
        </div>
        
        <div id="chat-log" class="h-96 p-4 overflow-y-auto bg-slate-50 space-y-4">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white flex items-center justify-center text-xs font-bold">
                    IK
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 max-w-xl shadow-sm border border-slate-100">
                    <div class="font-medium text-slate-900 mb-1">Hello! I'm IrahKun 👋</div>
                    <div class="text-sm text-slate-600">
                        I'm here to help you with facility reservations. You can ask me about:
                    </div>
                    <ul class="text-sm text-slate-600 mt-2 space-y-1">
                        <li class="flex items-center gap-2"><span class="text-blue-500">•</span> Available facilities</li>
                        <li class="flex items-center gap-2"><span class="text-blue-500">•</span> Scheduling conflicts</li>
                        <li class="flex items-center gap-2"><span class="text-blue-500">•</span> Booking recommendations</li>
                        <li class="flex items-center gap-2"><span class="text-blue-500">•</span> Reservation status</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <form id="chat-form" class="p-4 border-t border-slate-200 bg-white">
            @csrf
            <div class="flex items-center gap-2">
                <input type="text" id="chat-input" name="message" 
                       class="flex-1 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5" 
                       placeholder="Type your question about facilities or reservations..." 
                       required>
                <input type="submit"
                       value="Send"
                       class="px-5 py-3.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200 cursor-pointer">
            </div>
            <div class="mt-3 text-xs text-slate-500 flex items-center justify-center gap-4">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Checks conflicts
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Secure & Private
                </span>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        const form = document.getElementById('chat-form');
        const input = document.getElementById('chat-input');
        const log = document.getElementById('chat-log');
        const submitControl = form.querySelector('input[type=\"submit\"]');

        const csrf = form.querySelector('input[name="_token"]').value;

        function appendMessage(content, from = 'user') {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-start gap-3 ' + (from === 'user' ? 'flex-row-reverse' : '');

            const bubble = document.createElement('div');
            bubble.className = 'rounded-2xl px-4 py-3 max-w-xl shadow-sm border ' + 
                (from === 'user' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-tr-none ml-auto' : 'bg-white text-slate-900 rounded-tl-none border-slate-100');
            bubble.innerText = content;

            if (from === 'bot') {
                const avatar = document.createElement('div');
                avatar.className = 'w-8 h-8 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white flex items-center justify-center text-xs font-bold';
                avatar.innerText = 'IK';
                wrapper.appendChild(avatar);
            }

            wrapper.appendChild(bubble);
            
            if (from === 'user') {
                const userAvatar = document.createElement('div');
                userAvatar.className = 'w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-medium text-slate-700';
                userAvatar.innerText = '{{ substr(auth()->user()->name, 0, 1) }}';
                wrapper.appendChild(userAvatar);
            }

            log.appendChild(wrapper);
            log.scrollTop = log.scrollHeight;
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = input.value.trim();
            if (!message) return;
            
            appendMessage(message, 'user');
            input.value = '';
            input.disabled = true;
            if (submitControl) {
                submitControl.disabled = true;
            }

            try {
                const response = await fetch('{{ route('user.chat.message') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                if (!response.ok || data.error) {
                    appendMessage(data.error || 'Service is currently unavailable. Please try again later.', 'bot');
                } else {
                    appendMessage(data.reply, 'bot');
                }
            } catch (error) {
                appendMessage('Unable to connect to IrahKun. Please check your connection and try again.', 'bot');
            } finally {
                input.disabled = false;
                if (submitControl) {
                    submitControl.disabled = false;
                }
                input.focus();
            }
        });

        // Auto-focus input on load
        document.addEventListener('DOMContentLoaded', () => {
            input.focus();
        });
    </script>
    @endpush
@endsection
