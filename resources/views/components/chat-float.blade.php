@auth
<div id="irahkun-container" class="fixed bottom-24 right-6 w-96 max-w-sm bg-white rounded-2xl shadow-2xl hidden flex-col overflow-hidden z-50 border border-slate-200">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">
                IK
            </div>
            <div>
                <div class="text-sm font-bold text-white">IrahKun Assistant</div>
                <div class="text-xs text-blue-100">Ask about facilities or conflicts</div>
            </div>
        </div>
        <button type="button" id="irahkun-close" 
                class="text-white hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center transition duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    
    <div id="irahkun-log" class="p-4 space-y-3 h-80 overflow-y-auto text-sm text-slate-800 bg-slate-50">
        <div class="flex items-start gap-3">
            <div class="w-7 h-7 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white flex items-center justify-center text-xs font-bold">
                IK
            </div>
            <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 max-w-full shadow-sm border border-slate-100">
                <div class="font-medium text-slate-900 mb-1">Hi! I'm IrahKun 👋</div>
                <div class="text-slate-600">
                    Ask me anything about facilities or reservations. I'll remind you to check for conflicts before confirming bookings.
                </div>
            </div>
        </div>
    </div>
    
    <form id="irahkun-form" class="p-4 bg-white border-t border-slate-200">
        <div class="flex items-center gap-2">
            <input type="text" id="irahkun-input" name="message" 
                   class="flex-1 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" 
                   placeholder="Type your question..." 
                   required>
            <button type="submit" 
                    class="p-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </button>
        </div>
        <div class="mt-3 text-xs text-slate-500 flex items-center justify-center gap-3">
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Conflict detection
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Secure AI
            </span>
        </div>
    </form>
</div>

<button id="irahkun-toggle" type="button" 
        class="fixed bottom-6 right-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-full shadow-2xl w-16 h-16 flex items-center justify-center text-2xl hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300/50 z-50 transition duration-200 hover:scale-110">
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
            wrapper.className = 'flex items-start gap-3 ' + (from === 'user' ? 'flex-row-reverse' : '');
            
            const bubble = document.createElement('div');
            bubble.className = 'rounded-2xl px-4 py-3 max-w-[85%] shadow-sm border ' + 
                (from === 'user' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-tr-none' : 'bg-white text-slate-800 rounded-tl-none border-slate-100');
            bubble.innerText = content;

            if (from === 'bot') {
                const avatar = document.createElement('div');
                avatar.className = 'w-7 h-7 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white flex items-center justify-center text-xs font-bold';
                avatar.innerText = 'IK';
                wrapper.appendChild(avatar);
            }

            wrapper.appendChild(bubble);
            
            if (from === 'user') {
                const userAvatar = document.createElement('div');
                userAvatar.className = 'w-7 h-7 rounded-full bg-slate-200 flex items-center justify-center text-xs font-medium text-slate-700';
                userAvatar.innerText = '{{ substr(auth()->user()->name, 0, 1) }}';
                wrapper.appendChild(userAvatar);
            }

            log.appendChild(wrapper);
            log.scrollTop = log.scrollHeight;
        };

        toggle?.addEventListener('click', () => {
            container.classList.toggle('hidden');
            container.classList.toggle('flex');
            if (!container.classList.contains('hidden')) {
                input.focus();
                // Add entrance animation
                container.style.transform = 'translateY(20px)';
                container.style.opacity = '0';
                setTimeout(() => {
                    container.style.transform = 'translateY(0)';
                    container.style.opacity = '1';
                }, 10);
            }
        });

        closeBtn?.addEventListener('click', () => {
            container.classList.add('hidden');
            container.classList.remove('flex');
        });

        form?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = input.value.trim();
            if (!message) return;
            
            appendMessage(message, 'user');
            input.value = '';
            input.disabled = true;
            form.querySelector('button').disabled = true;

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
                appendMessage('IrahKun could not respond. Please check your connection and try again.', 'bot');
            } finally {
                input.disabled = false;
                form.querySelector('button').disabled = false;
                input.focus();
            }
        });

        // Add typing indicator if needed
        function showTypingIndicator() {
            const typingEl = document.createElement('div');
            typingEl.className = 'flex items-start gap-3';
            typingEl.innerHTML = `
                <div class="w-7 h-7 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white flex items-center justify-center text-xs font-bold">
                    IK
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm border border-slate-100">
                    <div class="flex gap-1">
                        <div class="w-2 h-2 rounded-full bg-slate-300 animate-pulse"></div>
                        <div class="w-2 h-2 rounded-full bg-slate-300 animate-pulse delay-150"></div>
                        <div class="w-2 h-2 rounded-full bg-slate-300 animate-pulse delay-300"></div>
                    </div>
                </div>
            `;
            log.appendChild(typingEl);
            return typingEl;
        }
    })();
</script>
@endpush
@endauth