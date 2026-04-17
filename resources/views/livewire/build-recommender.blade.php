<div>
    {{-- FORM --}}
    <form wire:submit="recommend" class="space-y-6">

        {{-- Budget --}}
        <div>
            <label class="block text-sm font-medium text-charcoal mb-2">
                Budget kamu berapa?
            </label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-charcoal/40 text-sm">Rp</span>
                <input type="number" wire:model="budget" placeholder="5000000" class="w-full pl-10 pr-4 py-3 rounded-xl border border-charcoal/10 bg-white
                           focus:outline-none focus:border-terracotta transition text-charcoal" />
            </div>
            @error('budget')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-charcoal/40 mt-1">
                Min: Rp 1.500.000 — Max: Rp 100.000.000
            </p>
        </div>

        {{-- Use Case --}}
        <div>
            <label class="block text-sm font-medium text-charcoal mb-3">
                Untuk apa PC ini?
            </label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach(['gaming' => '🎮 Gaming', 'work' => '💼 Kerja', 'editing' => '🎬 Editing', 'study' => '📚 Kuliah'] as $value => $label)
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="useCase" value="{{ $value }}" class="sr-only peer">
                        <div class="p-4 rounded-xl border border-charcoal/10 bg-white text-center text-sm
                                    font-medium transition cursor-pointer
                                    peer-checked:border-terracotta peer-checked:bg-terracotta/10
                                    peer-checked:text-terracotta hover:border-charcoal/30">
                            {{ $label }}
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Brand --}}
        <div>
            <label class="block text-sm font-medium text-charcoal mb-3">
                Preferensi brand?
            </label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach(['any' => 'Semua Brand', 'AMD' => 'AMD', 'Intel' => 'Intel', 'NVIDIA' => 'NVIDIA'] as $value => $label)
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="brandPreference" value="{{ $value }}" class="sr-only peer">
                        <div class="p-3 rounded-xl border border-charcoal/10 bg-white text-center text-sm
                                    font-medium transition
                                    peer-checked:border-terracotta peer-checked:bg-terracotta/10
                                    peer-checked:text-terracotta hover:border-charcoal/30">
                            {{ $label }}
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- GPU Toggle --}}
        <div class="flex items-center justify-between p-4 rounded-xl bg-white border border-charcoal/10">
            <div>
                <p class="text-sm font-medium text-charcoal">Sudah punya GPU?</p>
                <p class="text-xs text-charcoal/40 mt-0.5">Matikan jika sudah punya kartu grafis sendiri</p>
            </div>
            <button type="button" wire:click="$toggle('includeGpu')" class="relative w-12 h-6 rounded-full transition-colors duration-200
                       {{ $includeGpu ? 'bg-terracotta' : 'bg-charcoal/20' }}">
                <span class="absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-all duration-200
                             {{ $includeGpu ? 'left-7' : 'left-1' }}"></span>
            </button>
        </div>

        {{-- PSU Toggle --}}
        <div class="flex items-center justify-between p-4 rounded-xl bg-white border border-charcoal/10">
            <div>
                <p class="text-sm font-medium text-charcoal">Sudah punya PSU?</p>
                <p class="text-xs text-charcoal/40 mt-0.5">Matikan jika sudah punya power supply sendiri</p>
            </div>
            <button type="button" wire:click="$toggle('includePsu')" class="relative w-12 h-6 rounded-full transition-colors duration-200
                       {{ $includePsu ? 'bg-terracotta' : 'bg-charcoal/20' }}">
                <span class="absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-all duration-200
                             {{ $includePsu ? 'left-7' : 'left-1' }}"></span>
            </button>
        </div>

        {{-- Submit --}}
        <button type="submit" wire:loading.attr="disabled" class="w-full py-4 bg-charcoal text-parchment font-medium rounded-xl
                   hover:bg-charcoal/90 disabled:opacity-50 transition">
            <span wire:loading.remove wire:target="recommend">Temukan Build Terbaik →</span>
            <span wire:loading wire:target="recommend">Sedang menganalisis...</span>
        </button>
    </form>

    {{-- ERROR --}}
    @if(session('error'))
        <div class="mt-4 p-4 rounded-xl bg-red-50 border border-red-200">
            <p class="text-sm text-red-600">{{ session('error') }}</p>
        </div>
    @endif

    {{-- HASIL --}}
    @if($hasResult)
        <div class="mt-10 space-y-6">

            {{-- Header --}}
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-charcoal">Rekomendasi Build</h2>
                    <p class="text-sm text-charcoal/50 mt-1">
                        {{ ucfirst($result['use_case']) }} •
                        Budget Rp {{ number_format($result['budget'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-charcoal/40">Performance Score</p>
                    <p class="text-3xl font-semibold text-terracotta">
                        {{ $result['performance_score'] }}<span class="text-base text-charcoal/30">/100</span>
                    </p>
                </div>
            </div>

            {{-- Warnings --}}
            @if(!empty($result['bottleneck_warnings']))
                <div class="space-y-3">
                    @foreach($result['bottleneck_warnings'] as $warning)
                        <div class="p-4 rounded-xl border
                            {{ $warning['severity'] === 'high' ? 'border-red-200 bg-red-50' : 'border-amber-200 bg-amber-50' }}">
                            <p class="text-sm font-medium
                                {{ $warning['severity'] === 'high' ? 'text-red-700' : 'text-amber-700' }}">
                                ⚠ {{ $warning['message'] }}
                            </p>
                            <p class="text-xs mt-1
                                {{ $warning['severity'] === 'high' ? 'text-red-500' : 'text-amber-600' }}">
                                {{ $warning['detail'] }}
                            </p>
                            @if($warning['suggestion'])
                                <p class="text-xs mt-2 font-medium
                                    {{ $warning['severity'] === 'high' ? 'text-red-700' : 'text-amber-700' }}">
                                    💡 {{ $warning['suggestion'] }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Komponen --}}
            <div class="space-y-3">
                @foreach($result['components'] as $slug => $component)
                    <div class="p-4 rounded-xl bg-white border border-charcoal/8 flex items-center justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-terracotta uppercase tracking-wider">
                                {{ strtoupper($slug) }}
                            </p>
                            <p class="text-sm font-semibold text-charcoal mt-0.5 truncate">
                                {{ $component->name }}
                            </p>
                            <p class="text-xs text-charcoal/40 mt-0.5">
                                {{ $component->brand }}
                                @if($component->tdp)
                                    · {{ $component->tdp }}W TDP
                                @endif
                                · Score: {{ $component->performance_score ?? '-' }}
                            </p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-sm font-semibold text-charcoal">
                                Rp {{ number_format($component->base_price, 0, ',', '.') }}
                            </p>
                            @if($component->prices->isNotEmpty())
                                <a href="{{ $component->prices->first()->marketplace_url }}" target="_blank"
                                    class="text-xs text-terracotta hover:underline">
                                    Cek di {{ ucfirst($component->prices->first()->marketplace) }} →
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Total --}}
            <div class="p-5 rounded-xl bg-charcoal text-parchment flex justify-between items-center">
                <div>
                    <p class="text-xs opacity-50">Total Harga</p>
                    <p class="text-xl font-semibold">
                        Rp {{ number_format($result['total_price'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs opacity-50">Sisa Budget</p>
                    <p
                        class="text-lg font-semibold {{ ($result['budget'] - $result['total_price']) >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        Rp {{ number_format($result['budget'] - $result['total_price'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Action --}}
            <div class="grid grid-cols-2 gap-3">
                <a href="/compatibility" class="py-3 rounded-xl border border-charcoal/20 text-center text-sm
                          font-medium text-charcoal hover:bg-charcoal/5 transition">
                    Cek Kompatibilitas
                </a>
                <a href="/compare" class="py-3 rounded-xl border border-charcoal/20 text-center text-sm
                          font-medium text-charcoal hover:bg-charcoal/5 transition">
                    Bandingkan Build
                </a>
            </div>

            <button wire:click="resetForm" class="w-full text-sm text-charcoal/30 hover:text-charcoal/60 transition">
                ← Buat build baru
            </button>
        </div>
    @endif
</div>