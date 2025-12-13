@auth
<div id="irahkun-container" class="fixed bottom-24 right-6 w-80 max-w-sm bg-white border border-slate-200 rounded-xl shadow-xl hidden flex-col overflow-hidden z-50">
    <div class="bg-blue-600 text-white px-4 py-3 flex items-center justify-between">
        <div>
            <div class="text-sm font-semibold">IrahKun</div>
            <div class="text-xs text-blue-100">Ask about facilities or conflicts</div>
        </div>
        <button type="button" id="irahkun-close" class="text-white text-lg leading-none">&times;</button>
    </div>
    <div id="irahkun-log" class="p-3 space-y-2 h-64 overflow-y-auto text-sm text-slate-800 bg-slate-50">
        <div class="flex items-start gap-2">
            <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">IK</div>
            <div class="bg-white rounded-lg px-3 py-2 max-w-full">
                Hi! I'm IrahKun. Ask me anything about facilities or reservations. I'll remind you to check for conflicts before confirming bookings.
            </div>
        </div>
    </div>
    <form id="irahkun-form" class="p-3 bg-white border-t border-slate-200 flex items-center gap-2">
        @csrf
        <input type="text" id="irahkun-input" name="message" class="flex-1 rounded-lg border-slate-200 text-sm" placeholder="Type your question..." required>
        <button type="submit" class="px-3 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700">Send</button>
    </form>
</div>

<button id="irahkun-toggle" type="button" class="fixed bottom-6 right-6 bg-blue-600 text-white rounded-full shadow-lg w-14 h-14 flex items-center justify-center text-lg hover:bg-blue-700 z-50">
    💬
</button>

@push('scripts')
<script>
    (() => {
        const toggle = document.getElementById('irahkun-toggle');
        const container = document.getElementById('irahkun-container');
        const closeBtn = document.getElementById('irahkun-close');
        const form = document.getElementById('irahkun-form');
        const input = document.getElementById('irahkun-input');
        const log = document.getElementById('irahkun-log');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || form.querySelector('input[name="_token"]').value;

        const appendMessage = (content, from = 'bot') => {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-start gap-2 ' + (from === 'user' ? 'justify-end' : '');
            const bubble = document.createElement('div');
            bubble.className = 'rounded-lg px-3 py-2 max-w-[85%] ' + (from === 'user' ? 'bg-blue-600 text-white' : 'bg-white text-slate-800');
            bubble.innerText = content;

            if (from === 'bot') {
                const avatar = document.createElement('div');
                avatar.className = 'w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs';
                avatar.innerText = 'IK';
                wrapper.appendChild(avatar);
                wrapper.appendChild(bubble);
            } else {
                wrapper.appendChild(bubble);
            }

            log.appendChild(wrapper);
            log.scrollTop = log.scrollHeight;
        };

        toggle?.addEventListener('click', () => {
            container.classList.toggle('hidden');
            if (!container.classList.contains('hidden')) {
                input.focus();
            }
        });

        closeBtn?.addEventListener('click', () => {
            container.classList.add('hidden');
        });

        form?.addEventListener('submit', async (e) => {
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
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ message })
                });
                const data = await response.json();
                const reply = data.reply || data.error || 'IrahKun could not respond. Check GROQ_API_KEY or network.';
                appendMessage(reply, 'bot');
            } catch (error) {
                appendMessage('IrahKun could not respond. Check GROQ_API_KEY or network.', 'bot');
            }
        });
    })();
</script>
@endpush
@endauth
