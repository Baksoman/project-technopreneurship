<div class="space-y-8">

    {{-- Input Dua Build --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @foreach([
            ['label' => 'Build A', 'mode' => 'modeA', 'savedId' => 'savedBuildIdA', 'budget' => 'budgetA', 'useCase' => 'useCaseA', 'brand' => 'brandPreferenceA', 'buildMode' => 'modeA_build', 'gpu' => 'includeGpuA', 'psu' => 'includePsuA'],
            ['label' => 'Build B', 'mode' => 'modeB', 'savedId' => 'savedBuildIdB', 'budget' => 'budgetB', 'useCase' => 'useCaseB', 'brand' => 'brandPreferenceB', 'buildMode' => 'modeB_build', 'gpu' => 'includeGpuB', 'psu' => 'includePsuB'],
        ] as $build)

        <div class="bg-white rounded-2xl p-6 border border-charcoal/8">
            <h3 class="text-sm font-semibold text-terracotta uppercase tracking-wider mb-4">
                {{ $build['label'] }}
            </h3>

            {{-- Mode Selector --}}
            <div class="flex gap-2 p-1 bg-charcoal/5 rounded-lg mb-4">
                <button wire:click="$set('{{ $build['mode'] }}', 'new')" class="flex-1 py-1.5 rounded text-xs font-medium transition
                           {{ $this->{$build['mode']} === 'new' ? 'bg-white text-charcoal shadow' : 'text-charcoal/50' }}">
                    Buat Baru
                </button>
                <button wire:click="$set('{{ $build['mode'] }}', 'saved')" class="flex-1 py-1.5 rounded text-xs font-medium transition
                           {{ $this->{$build['mode']} === 'saved' ? 'bg-white text-charcoal shadow' : 'text-charcoal/50' }}">
                    Build Tersimpan
                </button>
            </div>

            @if($this->{$build['mode']} === 'saved')
                {{-- Saved Build Selector --}}
                <div>
                    @if(session('user_id'))
                        @if($savedBuilds->isNotEmpty())
                            <select wire:model="{{ $build['savedId'] }}"
                                class="w-full px-3 py-2.5 rounded-xl border border-charcoal/10 text-sm
                                       focus:outline-none focus:border-terracotta transition bg-white">
                                <option value="">-- Pilih Build --</option>
                                @foreach($savedBuilds as $sb)
                                    <option value="{{ $sb->id }}">
                                        {{ $sb->name }} - Rp {{ number_format($sb->total_price / 1000000, 1) }}jt
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <p class="text-xs text-charcoal/50 text-center py-4">Belum ada build tersimpan</p>
                        @endif
                    @else
                        <p class="text-xs text-charcoal/50 text-center py-4"><a href="{{ route('login') }}" class="text-terracotta hover:underline">Login</a> dulu</p>
                    @endif
                </div>
            @else
                {{-- New Build Form --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-charcoal/50 mb-1">Budget</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-charcoal/40 text-xs">Rp</span>
                            <input type="number" wire:model="{{ $build['budget'] }}"
                                class="w-full pl-9 pr-3 py-2 rounded-xl border border-charcoal/10 text-sm
                                       focus:outline-none focus:border-terracotta transition"/>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs text-charcoal/50 mb-1">Prioritas</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" wire:model="{{ $build['buildMode'] }}" value="balanced" class="sr-only peer">
                                <div class="p-2 rounded-lg border border-charcoal/10 bg-white text-center text-xs transition
                                            peer-checked:border-terracotta peer-checked:bg-terracotta/10 peer-checked:text-terracotta">
                                    Price to Performance
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" wire:model="{{ $build['buildMode'] }}" value="max_budget" class="sr-only peer">
                                <div class="p-2 rounded-lg border border-charcoal/10 bg-white text-center text-xs transition
                                            peer-checked:border-terracotta peer-checked:bg-terracotta/10 peer-checked:text-terracotta">
                                    Max Budget
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs text-charcoal/50 mb-1">Use Case</label>
                        <select wire:model="{{ $build['useCase'] }}"
                            class="w-full px-3 py-2 rounded-xl border border-charcoal/10 text-sm
                                   focus:outline-none focus:border-terracotta transition bg-white">
                            <option value="gaming">Gaming</option>
                            <option value="work">Kerja</option>
                            <option value="editing">Editing</option>
                            <option value="study">Kuliah</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-charcoal/50 mb-1">Brand</label>
                        <select wire:model="{{ $build['brand'] }}"
                            class="w-full px-3 py-2 rounded-xl border border-charcoal/10 text-sm
                                   focus:outline-none focus:border-terracotta transition bg-white">
                            <option value="any">Semua</option>
                            <option value="AMD">AMD</option>
                            <option value="Intel">Intel</option>
                            <option value="NVIDIA">NVIDIA</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center justify-between p-2 rounded-lg bg-white border border-charcoal/10 cursor-pointer">
                            <span class="text-xs text-charcoal/70">GPU</span>
                            <button type="button" wire:click="$toggle('{{ $build['gpu'] }}')"
                                class="relative w-10 h-5 rounded-full transition-colors duration-200
                                       {{ $this->{$build['gpu']} ? 'bg-terracotta' : 'bg-charcoal/20' }}">
                                <span class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow transition-all duration-200
                                             {{ $this->{$build['gpu']} ? 'left-5' : 'left-0.5' }}"></span>
                            </button>
                        </label>
                    </div>
                </div>
            @endif
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

        {{-- Error Notifications --}}
        @php
            $buildAFailed = !($buildA['success'] ?? true);
            $buildBFailed = !($buildB['success'] ?? true);
        @endphp

        @if($buildAFailed || $buildBFailed)
            <div class="space-y-4">
                @if($buildAFailed)
                    <div class="p-6 rounded-2xl border border-red-200 bg-red-50 space-y-3">
                        <p class="text-sm font-semibold text-red-700">Build A Gagal</p>
                        <p class="text-sm text-red-600">{{ $buildA['message'] }}</p>
                        <p class="text-xs text-red-500">{{ $buildA['detail'] }}</p>
                        @if(!empty($buildA['missing_categories']))
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($buildA['missing_categories'] as $cat)
                                    <span class="px-2 py-1 rounded-full bg-red-100 text-red-600 text-xs font-medium">
                                        {{ strtoupper($cat) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if($buildBFailed)
                    <div class="p-6 rounded-2xl border border-red-200 bg-red-50 space-y-3">
                        <p class="text-sm font-semibold text-red-700">Build B Gagal</p>
                        <p class="text-sm text-red-600">{{ $buildB['message'] }}</p>
                        <p class="text-xs text-red-500">{{ $buildB['detail'] }}</p>
                        @if(!empty($buildB['missing_categories']))
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($buildB['missing_categories'] as $cat)
                                    <span class="px-2 py-1 rounded-full bg-red-100 text-red-600 text-xs font-medium">
                                        {{ strtoupper($cat) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        {{-- Only show comparison if both builds succeeded --}}
        @if(!$buildAFailed && !$buildBFailed)

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
                <p class="text-sm font-semibold text-terracotta">Build A lebih berperforma tinggi</p>
            @elseif($scoreB > $scoreA)
                <p class="text-sm font-semibold text-terracotta">Build B lebih berperforma tinggi</p>
            @else
                <p class="text-sm font-semibold text-terracotta">Performa kedua build setara</p>
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
                    <p class="text-xs text-charcoal/30">-</p>
                    @endif
                </div>

                <div class="text-center">
                    @if($compB)
                    <p class="text-xs font-medium text-charcoal leading-snug">{{ $compB->name }}</p>
                    <p class="text-xs text-charcoal/40 mt-0.5">Rp {{ number_format($compB->base_price, 0, ',', '.') }}</p>
                    <p class="text-xs text-charcoal/30">Score: {{ $compB->performance_score ?? '-' }}</p>
                    @else
                    <p class="text-xs text-charcoal/30">-</p>
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
            <p class="text-xs font-semibold text-charcoal/50 uppercase">Warning - {{ $item['label'] }}</p>
            @foreach($item['build']['bottleneck_warnings'] as $w)
            <div class="p-3 rounded-xl border border-amber-200 bg-amber-50">
                <p class="text-xs font-medium text-amber-700">{{ $w['message'] }}</p>
                @if($w['suggestion'])
                <p class="text-xs text-amber-600 mt-1">{{ $w['suggestion'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif
        @endforeach

        @endif {{-- end both builds succeeded --}}

    </div>
    @endif
</div>