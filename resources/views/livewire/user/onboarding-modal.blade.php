<div x-data="{ 
    show: @entangle('show'),
    currentSlide: @entangle('currentSlide').live,
    touchStartX: 0,
    touchEndX: 0,
    handleSwipe() {
        if (this.touchEndX < this.touchStartX - 50 && this.currentSlide < 3) {
            this.currentSlide++;
        }
        if (this.touchEndX > this.touchStartX + 50 && this.currentSlide > 0) {
            this.currentSlide--;
        }
    }
}" 
x-show="show" 
x-cloak
@touchstart="touchStartX = $event.changedTouches[0].screenX"
@touchend="touchEndX = $event.changedTouches[0].screenX; handleSwipe()"
class="fixed inset-0 z-[100] flex items-center justify-center bg-charcoal/90 backdrop-blur-sm"
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0">

    <div class="bg-parchment w-full h-full overflow-hidden relative flex flex-col">
        
        <div class="flex-1 relative overflow-hidden">
            <div class="absolute inset-0 transition-transform duration-300 ease-out flex"
                :style="`transform: translateX(-${currentSlide * 100}%)`">
                
                <div class="min-w-full flex flex-col items-center justify-center p-8 text-center">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-terracotta to-terracotta/60 flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-charcoal mb-4">Smart Builder</h2>
                    <p class="text-charcoal/70 leading-relaxed">Masukkan budget dan kebutuhanmu, kami akan merekomendasikan build PC terbaik dengan komponen yang optimal dan seimbang</p>
                </div>

                <div class="min-w-full flex flex-col items-center justify-center p-8 text-center">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-terracotta to-terracotta/60 flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-charcoal mb-4">Compatibility Check</h2>
                    <p class="text-charcoal/70 leading-relaxed">Cek kompatibilitas antar komponen secara otomatis. Pastikan semua part yang kamu pilih cocok satu sama lain</p>
                </div>

                <div class="min-w-full flex flex-col items-center justify-center p-8 text-center">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-terracotta to-terracotta/60 flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-charcoal mb-4">Build Comparison</h2>
                    <p class="text-charcoal/70 leading-relaxed">Bandingkan dua build berbeda untuk melihat performa, harga, dan value terbaik sesuai kebutuhanmu</p>
                </div>

                <div class="min-w-full flex flex-col items-center justify-center p-8 text-center">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-terracotta to-terracotta/60 flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-charcoal mb-4">Siap Mulai?</h2>
                    <p class="text-charcoal/70 leading-relaxed mb-8">Rakit PC impianmu sekarang dengan bantuan AI kami. Mudah, cepat, dan akurat!</p>
                    <button wire:click="close" class="bg-gradient-to-r from-terracotta to-terracotta/80 text-white px-8 py-4 rounded-2xl font-semibold hover:shadow-xl transition-all transform hover:scale-105">
                        Buat PC-mu Sekarang
                    </button>
                </div>

            </div>
        </div>

        <div class="p-8 flex items-center justify-center gap-2">
            <button @click="currentSlide > 0 && currentSlide--" 
                x-show="currentSlide > 0"
                class="w-10 h-10 rounded-full bg-charcoal/10 hover:bg-charcoal/20 flex items-center justify-center transition">
                <svg class="w-5 h-5 text-charcoal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <div class="flex gap-2 mx-4">
                <template x-for="i in 4" :key="i">
                    <div class="w-2 h-2 rounded-full transition-all duration-300"
                        :class="currentSlide === i - 1 ? 'bg-terracotta w-8' : 'bg-charcoal/20'">
                    </div>
                </template>
            </div>

            <button @click="currentSlide < 3 && currentSlide++" 
                x-show="currentSlide < 3"
                class="w-10 h-10 rounded-full bg-charcoal/10 hover:bg-charcoal/20 flex items-center justify-center transition">
                <svg class="w-5 h-5 text-charcoal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

    </div>
</div>
