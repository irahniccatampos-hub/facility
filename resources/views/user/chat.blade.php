@extends('layouts.user')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">IrahKun</h1>
            <p class="text-slate-600">Chat with your assistant. IrahKun will remind you to check reservation conflicts.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4">
        <div id="chat-log" class="h-80 overflow-y-auto space-y-3 text-sm text-slate-800">
            <div class="flex items-start gap-2">
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">IK</div>
                <div class="bg-slate-100 rounded-lg px-3 py-2 max-w-xl">
                    Hi! I'm IrahKun. Ask me anything about facilities or reservations. I'll remind you to avoid conflicts before booking.
                </div>
            </div>
        </div>
        <form id="chat-form" class="mt-4 flex items-center gap-2">
            @csrf
            <input type="text" id="chat-input" name="message" class="flex-1 rounded-lg border-slate-200" placeholder="Type your question..." required>
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Send</button>
        </form>
    </div>

    @push('scripts')
    <script>
        const form = document.getElementById('chat-form');
        const input = document.getElementById('chat-input');
        const log = document.getElementById('chat-log');

        const csrf = form.querySelector('input[name="_token"]').value;

        function appendMessage(content, from = 'user') {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-start gap-2 ' + (from === 'user' ? 'justify-end' : '');

            const bubble = document.createElement('div');
            bubble.className = 'rounded-lg px-3 py-2 max-w-xl ' + (from === 'user' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-800');
            bubble.innerText = content;

            if (from === 'bot') {
                const avatar = document.createElement('div');
                avatar.className = 'w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs';
                avatar.innerText = 'IK';
                wrapper.appendChild(avatar);
                wrapper.appendChild(bubble);
            } else {
                wrapper.appendChild(bubble);
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
                    appendMessage(data.error || 'Service unavailable.', 'bot');
                } else {
                    appendMessage(data.reply, 'bot');
                }
            } catch (error) {
                appendMessage('Service unavailable.', 'bot');
            }
        });
    </script>
    @endpush
@endsection
