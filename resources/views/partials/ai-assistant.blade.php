<!-- ═══════════════════════════════════════════════════════
     SYAFIQ AI - VIRTUAL INTELLIGENT PORTFOLIO ASSISTANT
     ═══════════════════════════════════════════════════════ -->
<div id="syafiq-ai-container" class="relative z-50" x-data="syafiqAiComponent()" x-cloak>
    <!-- Floating Launcher Trigger Button -->
    <div class="fixed bottom-24 right-4 sm:right-6 z-40 flex items-center gap-3">
        <!-- Floating Tooltip Prompt (Auto-appears) -->
        <div x-show="!isOpen && showTooltip" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-x-4 scale-95"
             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="hidden md:flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-[#0c0c14]/95 border border-indigo-500/30 text-xs text-slate-200 shadow-xl backdrop-blur-xl pointer-events-auto">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="font-medium">Ada pertanyaan? <b>Tanya Syafiq AI</b></span>
            <button @click.stop="showTooltip = false" class="text-slate-400 hover:text-white text-xs ml-1">&times;</button>
        </div>

        <button @click="toggleChat()" 
                id="syafiq-ai-launcher"
                class="relative w-14 h-14 rounded-full bg-gradient-to-tr from-indigo-600 via-purple-600 to-cyan-400 p-[2px] shadow-[0_0_25px_rgba(99,102,241,0.5)] hover:shadow-[0_0_35px_rgba(99,102,241,0.8)] hover:scale-105 active:scale-95 transition-all duration-300 group cursor-pointer"
                title="Buka Asisten Cerdas Syafiq AI"
                aria-label="Buka Asisten Cerdas Syafiq AI">
            <div class="w-full h-full rounded-full bg-[#0c0c14] flex items-center justify-center overflow-hidden relative">
                @if(isset($profile) && $profile->avatar)
                    <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Syafiq AI" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                @else
                    <i class='bx bx-bot text-2xl text-cyan-300 group-hover:scale-110 transition-transform duration-300'></i>
                @endif
                
                <!-- Online Status Dot -->
                <span class="absolute bottom-0 right-0 w-3.5 h-3.5 rounded-full bg-emerald-500 border-2 border-[#0c0c14] shadow-sm"></span>
            </div>

            <!-- Sparkle Badge -->
            <span class="absolute -top-1 -left-1 w-5 h-5 rounded-full bg-indigo-500 text-[10px] text-white flex items-center justify-center font-black shadow-md border border-white/30 animate-bounce">
                ✨
            </span>
        </button>
    </div>

    <!-- Interactive Chat Window Modal -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 scale-95"
         @click.outside="isOpen = false"
         class="fixed bottom-6 right-4 sm:right-6 z-50 w-[calc(100vw-2rem)] sm:w-[420px] max-w-[430px] h-[590px] max-h-[85vh] bg-[#0c0c14]/95 backdrop-blur-2xl border border-white/15 rounded-3xl shadow-[0_25px_60px_rgba(0,0,0,0.85)] flex flex-col overflow-hidden">
        
        <!-- Header -->
        <div class="px-5 py-3.5 bg-white/5 border-b border-white/10 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="relative w-10 h-10 rounded-full p-[1.5px] bg-gradient-to-tr from-indigo-500 via-purple-500 to-cyan-400 flex-shrink-0">
                    <div class="w-full h-full rounded-full bg-[#0c0c14] overflow-hidden flex items-center justify-center">
                        @if(isset($profile) && $profile->avatar)
                            <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <i class='bx bx-bot text-xl text-cyan-300'></i>
                        @endif
                    </div>
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full bg-emerald-400 border border-[#0c0c14] shadow-sm"></span>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <h3 class="font-bold text-sm font-['Space_Grotesk'] text-white">Syafiq AI</h3>
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-mono font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">v2.0</span>
                    </div>
                    <p class="text-[11px] text-slate-400 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Asisten Cerdas Portofolio</span>
                    </p>
                </div>
            </div>

            <!-- Controls (Sound & Close) -->
            <div class="flex items-center gap-1.5">
                <button @click="toggleSound()" 
                        :class="soundEnabled ? 'text-cyan-400 bg-cyan-500/10 border-cyan-500/30' : 'text-slate-400 bg-white/5 border-white/10'"
                        class="w-8 h-8 rounded-xl border flex items-center justify-center text-sm transition-all hover:scale-105 active:scale-95 cursor-pointer" 
                        :title="soundEnabled ? 'Matikan Suara AI' : 'Aktifkan Suara Bicara AI (TTS)'">
                    <i :class="soundEnabled ? 'bx bxs-volume-full' : 'bx bx-volume-mute'"></i>
                </button>
                <button @click="isOpen = false" 
                        class="w-8 h-8 rounded-xl bg-white/5 hover:bg-rose-500/20 border border-white/10 hover:border-rose-500/30 text-slate-400 hover:text-rose-400 flex items-center justify-center text-lg transition-all hover:scale-105 active:scale-95 cursor-pointer" 
                        title="Tutup Percakapan">
                    <i class='bx bx-x'></i>
                </button>
            </div>
        </div>

        <!-- Chat Messages Area -->
        <div id="syafiq-ai-messages" class="flex-1 overflow-y-auto p-4 sm:p-5 space-y-4 text-xs leading-relaxed custom-scrollbar">
            <!-- Initial Bot Greeting -->
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start gap-2.5'">
                    <!-- Bot Avatar for bot messages -->
                    <template x-if="msg.sender === 'bot'">
                        <div class="w-7 h-7 rounded-full bg-indigo-600/30 border border-indigo-400/40 text-cyan-300 flex items-center justify-center flex-shrink-0 text-xs mt-1">
                            🤖
                        </div>
                    </template>

                    <div :class="msg.sender === 'user' 
                                ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl rounded-br-sm px-4 py-3 max-w-[82%] shadow-md break-words' 
                                : 'bg-white/5 border border-white/10 text-slate-200 rounded-2xl rounded-tl-sm px-4 py-3 max-w-[85%] shadow-sm break-words'">
                        <!-- Message Content with Linebreaks formatting -->
                        <div x-html="formatMessage(msg.text)" class="space-y-1.5"></div>

                        <!-- Action Button if attached -->
                        <template x-if="msg.action">
                            <div class="mt-3 pt-2.5 border-t border-white/10">
                                <template x-if="msg.action.type === 'cv_modal'">
                                    <button @click="openCvModalDirectly()" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-500 hover:bg-indigo-600 text-white font-bold text-[11px] shadow-sm transition-all cursor-pointer">
                                        <i class='bx bx-file'></i>
                                        <span x-text="msg.action.label"></span>
                                    </button>
                                </template>
                                <template x-if="msg.action.type === 'link'">
                                    <a :href="msg.action.url" 
                                       @click="isOpen = false"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-bold text-[11px] shadow-sm transition-all">
                                        <span x-text="msg.action.label"></span>
                                        <i class='bx bx-right-arrow-alt'></i>
                                    </a>
                                </template>
                                <template x-if="msg.action.type === 'whatsapp'">
                                    <a :href="msg.action.url" 
                                       target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-[11px] shadow-sm transition-all">
                                        <i class='bx bxl-whatsapp text-sm'></i>
                                        <span x-text="msg.action.label"></span>
                                    </a>
                                </template>
                            </div>
                        </template>

                        <div class="text-[9px] text-right mt-1 opacity-50 font-mono" x-text="msg.time"></div>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex items-center gap-2.5 text-slate-400 text-xs">
                <div class="w-7 h-7 rounded-full bg-indigo-600/30 border border-indigo-400/40 text-cyan-300 flex items-center justify-center flex-shrink-0 text-xs">
                    🤖
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl rounded-tl-sm px-3.5 py-2.5 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-bounce"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-400 animate-bounce [animation-delay:0.2s]"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-bounce [animation-delay:0.4s]"></span>
                    <span class="text-[10px] text-slate-400 ml-1">Syafiq AI sedang mengetik...</span>
                </div>
            </div>
        </div>

        <!-- Quick Prompt Chips -->
        <div class="px-4 py-2 border-t border-white/5 bg-black/30 overflow-x-auto flex items-center gap-1.5 no-scrollbar flex-shrink-0">
            <template x-for="(chip, i) in currentSuggestions" :key="i">
                <button @click="sendSuggestion(chip)" 
                        class="whitespace-nowrap px-3 py-1 rounded-full bg-white/5 hover:bg-indigo-600/30 border border-white/10 hover:border-indigo-500/40 text-slate-300 hover:text-white text-[11px] font-medium transition-all flex-shrink-0 cursor-pointer">
                    <span x-text="chip"></span>
                </button>
            </template>
        </div>

        <!-- Input Box Area -->
        <form @submit.prevent="sendMessage()" class="p-3 sm:p-4 bg-white/5 border-t border-white/10 flex items-center gap-2 flex-shrink-0">
            @csrf
            <input type="text" 
                   x-model="userInput" 
                   :disabled="isTyping"
                   placeholder="Tanyakan keahlian, magang, projek..." 
                   class="flex-1 bg-white/5 border border-white/10 focus:border-indigo-500 focus:bg-white/10 rounded-2xl px-4 py-2.5 text-xs text-white placeholder-slate-500 outline-none transition-all">
            
            <button type="submit" 
                    :disabled="isTyping || !userInput.trim()"
                    class="w-10 h-10 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-400 hover:to-purple-500 disabled:opacity-40 text-white flex items-center justify-center text-base shadow-md transition-all hover:scale-105 active:scale-95 cursor-pointer flex-shrink-0">
                <i class='bx bxs-send'></i>
            </button>
        </form>
    </div>
</div>

<script>
    function syafiqAiComponent() {
        return {
            isOpen: false,
            showTooltip: true,
            soundEnabled: false,
            isTyping: false,
            userInput: '',
            currentSuggestions: [
                '💼 Pengalaman Magang',
                '🎓 Riwayat Pendidikan',
                '🚀 Projek Unggulan',
                '⚡ Keahlian Koding',
                '📄 Lihat CV Syafiq',
                '💬 Chat WhatsApp'
            ],
            messages: [
                {
                    sender: 'bot',
                    text: "Halo! 👋 Saya **Syafiq AI**, asisten cerdas virtual Mhd. Syafiq Syahmi.\n\nSaya siap menjawab pertanyaan seputar keahlian koding, riwayat pendidikan Polmed, pengalaman magang di PT Pelindo & PT Telkom Akses, hingga estimasi projek Anda. Ada yang bisa saya bantu?",
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                    action: null
                }
            ],
            init() {
                // Auto hide tooltip after 8 seconds
                setTimeout(() => {
                    this.showTooltip = false;
                }, 8000);
            },
            toggleChat() {
                this.isOpen = !this.isOpen;
                this.showTooltip = false;
                if (this.isOpen) {
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                }
            },
            toggleSound() {
                this.soundEnabled = !this.soundEnabled;
                if (this.soundEnabled && 'speechSynthesis' in window) {
                    this.speakText("Suara asisten AI aktif.");
                }
            },
            scrollToBottom() {
                const el = document.getElementById('syafiq-ai-messages');
                if (el) {
                    el.scrollTop = el.scrollHeight;
                }
            },
            formatMessage(text) {
                if (!text) return '';
                // Simple markdown-style bold and list formatting
                let formatted = text
                    .replace(/\*\*(.*?)\*\*/g, '<strong class="text-white font-bold">$1</strong>')
                    .replace(/\n\n/g, '<div class="h-2"></div>')
                    .replace(/\n/g, '<br>');
                return formatted;
            },
            speakText(text) {
                if (!this.soundEnabled || !('speechSynthesis' in window)) return;
                window.speechSynthesis.cancel(); // Stop current speech
                // Strip markdown formatting for voice
                const cleanText = text.replace(/[*#_•\n]/g, ' ');
                const utterance = new SpeechSynthesisUtterance(cleanText);
                utterance.lang = 'id-ID';
                utterance.rate = 1.05;
                window.speechSynthesis.speak(utterance);
            },
            sendSuggestion(text) {
                this.userInput = text;
                this.sendMessage();
            },
            openCvModalDirectly() {
                this.isOpen = false;
                if (typeof openPdfModal === 'function') {
                    openPdfModal('/cv/stream', 'Curriculum Vitae - Mhd. Syafiq Syahmi', '/cv');
                } else {
                    window.open('/cv/stream', '_blank');
                }
            },
            async sendMessage() {
                const text = this.userInput.trim();
                if (!text || this.isTyping) return;

                // Push user message
                this.messages.push({
                    sender: 'user',
                    text: text,
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                });

                this.userInput = '';
                this.isTyping = true;
                this.$nextTick(() => this.scrollToBottom());

                try {
                    const response = await fetch('/ai/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message: text })
                    });

                    const data = await response.json();

                    // Artificial small delay for natural typing feel
                    await new Promise(r => setTimeout(r, 400));

                    if (data && data.reply) {
                        this.messages.push({
                            sender: 'bot',
                            text: data.reply,
                            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                            action: data.action || null
                        });

                        if (data.suggestions && data.suggestions.length > 0) {
                            this.currentSuggestions = data.suggestions;
                        }

                        if (this.soundEnabled) {
                            this.speakText(data.reply);
                        }
                    } else {
                        throw new Error('No reply');
                    }
                } catch (err) {
                    console.error('AI chat error:', err);
                    this.messages.push({
                        sender: 'bot',
                        text: "Maaf, terjadi sedikit gangguan koneksi. Anda bisa langsung chat Syafiq via WhatsApp ya!",
                        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        action: {
                            type: 'whatsapp',
                            label: 'Chat WhatsApp Syafiq',
                            url: 'https://wa.me/6282237905639'
                        }
                    });
                } finally {
                    this.isTyping = false;
                    this.$nextTick(() => this.scrollToBottom());
                }
            }
        };
    }
</script>
