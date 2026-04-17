<div class="space-y-8">

    {{-- Input Dua Build --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @foreach([
            ['label' => 'Build A', 'budget' => 'budgetA', 'useCase' => 'useCaseA', 'brand' => 'brandPreferenceA'],
            ['label' => 'Build B', 'budget' => 'budgetB', 'useCase' => 'useCaseB', 'brand' => 'brandPreferenceB'],
        ] as $build)

        <div class="bg-white rounded-2xl p-6 border border-charcoal/8">
            <h3 class="text-sm font-semibold text-terracotta uppercase tracking-wider mb-4">
                {{ $build['label'] }}
            </h3>

            {{-- Budget --}}
            <div class="mb-4">
                <label class="block text-xs text-charcoal/50 mb-1">Budget</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-charcoal/40 text-sm">Rp</span>
                    <input type="number" wire:model="{{ $build['budget'] }}"
                        class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-charcoal/10
                               text-sm focus:outline-none focus:border-terracotta transition"/>
                </div>
            </div>

            {{-- Use Case --}}
            <div class="mb-4">
                <label class="block text-xs text-charcoal/50 mb-1">Use Case</label>
                <select wire:model="{{ $build['useCase'] }}"
                    class="w-full px-3 py-2.5 rounded-xl border border-charcoal/10
                           text-sm focus:outline-none focus:border-terracotta transition bg-white">
                    <option value="gaming">🎮 Gaming</option>
                    <option value="work">💼 Kerja</option>
                    <option value="editing">🎬 Editing</option>
                    <option value="study">📚 Kuliah</option>
                </select>
            </div>

            {{-- Brand --}}
            <div>
                <label class="block text-xs text-charcoal/50 mb-1">Preferensi Brand</label>
                <select wire:model="{{ $build['brand'] }}"
                    class="w-full px-3 py-2.5 rounded-xl border border-charcoal/10
                           text-sm focus:outline-none focus:border-terracotta transition bg-white">
                    <option value="any">Semua Brand</option>
                    <option value="AMD">AMD</option>
                    <option value="Intel">Intel</option>
                    <option value="NVIDIA">NVIDIA</option>
                </select>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Button --}}
    <button wire:click="compare"
        class="w-full py-4 bg-charcoal text-parchment font-medium rounded-xl hover:bg-charcoal/90 transition">
        <span wire:loading.remove wire:target="compare">Bandingkan Build →</span>
        <span wire:loading wire:target="compare">Membandingkan...</span>
    </button>

    {{-- Hasil Comparison --}}
    @if($hasResult)
    <div class="space-y-4">

        {{-- Score Summary --}}
        <div class="grid grid-cols-2 gap-4">
            @foreach([['label' => 'Build A', 'build' => $buildA], ['label' => 'Build B', 'build' => $buildB]] as $item)
            <div class="p-5 rounded-2xl bg-white border border-charcoal/8 text-center">
                <p class="text-xs text-charcoal/40 uppercase tracking-wider">{{ $item['label'] }}</p>
                <p class="text-4xl font-semibold text-terracotta mt-1">
                    {{ $item['build']['performance_score'] }}
                    <span class="text-sm text-charcoal/30">/100</span>
                </p>
                <p class="text-sm font-medium text-charcoal mt-1">
                    Rp {{ number_format($item['build']['total_price'], 0, ',', '.') }}
                </p>
                <p class="text-xs text-charcoal/40 mt-0.5">{{ ucfirst($item['build']['use_case']) }}</p>
            </div>
            @endforeach
        </div>

        {{-- Verdict --}}
        @php
            $scoreA = $buildA['performance_score'];
            $scoreB = $buildB['performance_score'];
            $priceA = $buildA['total_price'];
            $priceB = $buildB['total_price'];
        @endphp
        <div class="p-4 rounded-xl bg-terracotta/10 border border-terracotta/20 text-center">
            @if($scoreA > $scoreB)
                <p class="text-sm font-semibold text-terracotta">🏆 Build A lebih berperforma tinggi</p>
            @elseif($scoreB > $scoreA)
                <p class="text-sm font-semibold text-terracotta">🏆 Build B lebih berperforma tinggi</p>
            @else
                <p class="text-sm font-semibold text-terracotta">🤝 Performa kedua build setara</p>
            @endif
            @if($priceA < $priceB)
                <p class="text-xs text-charcoal/50 mt-1">Build A lebih hemat Rp {{ number_format($priceB - $priceA, 0, ',', '.') }}</p>
            @elseif($priceB < $priceA)
                <p class="text-xs text-charcoal/50 mt-1">Build B lebih hemat Rp {{ number_format($priceA - $priceB, 0, ',', '.') }}</p>
            @endif
        </div>

        {{-- Komponen Side by Side --}}
        @php
            $categories = array_unique(array_merge(
                array_keys($buildA['components']),
                array_keys($buildB['components'])
            ));
        @endphp

        <div class="bg-white rounded-2xl border border-charcoal/8 overflow-hidden">
            {{-- Header --}}
            <div class="grid grid-cols-3 bg-charcoal/5 p-3 text-xs font-medium text-charcoal/50 uppercase tracking-wider">
                <div>Kategori</div>
                <div class="text-center">Build A</div>
                <div class="text-center">Build B</div>
            </div>

            {{-- Rows --}}
            @foreach($categories as $slug)
            @php
                $compA = $buildA['components'][$slug] ?? null;
                $compB = $buildB['components'][$slug] ?? null;
            @endphp
            <div class="grid grid-cols-3 p-4 border-t border-charcoal/5 items-start gap-2">
                <div class="text-xs font-semibold text-terracotta uppercase">{{ $slug }}</div>

                <div class="text-center">
                    @if($compA)
                    <p class="text-xs font-medium text-charcoal leading-snug">{{ $compA->name }}</p>
                    <p class="text-xs text-charcoal/40 mt-0.5">Rp {{ number_format($compA->base_price, 0, ',', '.') }}</p>
                    <p class="text-xs text-charcoal/30">Score: {{ $compA->performance_score ?? '-' }}</p>
                    @else
                    <p class="text-xs text-charcoal/30">—</p>
                    @endif
                </div>

                <div class="text-center">
                    @if($compB)
                    <p class="text-xs font-medium text-charcoal leading-snug">{{ $compB->name }}</p>
                    <p class="text-xs text-charcoal/40 mt-0.5">Rp {{ number_format($compB->base_price, 0, ',', '.') }}</p>
                    <p class="text-xs text-charcoal/30">Score: {{ $compB->performance_score ?? '-' }}</p>
                    @else
                    <p class="text-xs text-charcoal/30">—</p>
                    @endif
                </div>
            </div>
            @endforeach

            {{-- Total Row --}}
            <div class="grid grid-cols-3 p-4 border-t border-charcoal/20 bg-charcoal/5 items-center">
                <div class="text-xs font-semibold text-charcoal">TOTAL</div>
                <div class="text-center text-sm font-semibold text-charcoal">
                    Rp {{ number_format($buildA['total_price'], 0, ',', '.') }}
                </div>
                <div class="text-center text-sm font-semibold text-charcoal">
                    Rp {{ number_format($buildB['total_price'], 0, ',', '.') }}
                </div>
            </div>
        </div>

        {{-- Warnings per build --}}
        @foreach([['label' => 'Build A', 'build' => $buildA], ['label' => 'Build B', 'build' => $buildB]] as $item)
        @if(!empty($item['build']['bottleneck_warnings']))
        <div class="space-y-2">
            <p class="text-xs font-semibold text-charcoal/50 uppercase">⚠ Warning — {{ $item['label'] }}</p>
            @foreach($item['build']['bottleneck_warnings'] as $w)
            <div class="p-3 rounded-xl border border-amber-200 bg-amber-50">
                <p class="text-xs font-medium text-amber-700">{{ $w['message'] }}</p>
                @if($w['suggestion'])
                <p class="text-xs text-amber-600 mt-1">💡 {{ $w['suggestion'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif
        @endforeach

    </div>
    @endif
</div>