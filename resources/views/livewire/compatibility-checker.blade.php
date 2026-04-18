<div class="space-y-6">

    {{-- Mode Selector --}}
    <div class="flex gap-3 p-1 bg-charcoal/5 rounded-xl">
        <button wire:click="$set('inputMode', 'manual')" class="flex-1 py-2 rounded-lg text-sm font-medium transition
                   {{ $inputMode === 'manual' ? 'bg-white text-charcoal shadow' : 'text-charcoal/50' }}">
            Input Manual
        </button>
        <button wire:click="$set('inputMode', 'saved')" class="flex-1 py-2 rounded-lg text-sm font-medium transition
                   {{ $inputMode === 'saved' ? 'bg-white text-charcoal shadow' : 'text-charcoal/50' }}">
            Pilih Build Tersimpan
        </button>
    </div>

    {{-- Saved Build Selector --}}
    @if($inputMode === 'saved')
        <div>
            @if(session('user_id'))
                @if($savedBuilds->isNotEmpty())
                    <label class="block text-xs font-medium text-charcoal/50 uppercase tracking-wider mb-2">
                        Pilih Build
                    </label>
                    <select wire:model="selectedBuildId" wire:change="loadSavedBuild"
                        class="w-full px-4 py-3 rounded-xl border border-charcoal/10 bg-white text-charcoal text-sm
                               focus:outline-none focus:border-terracotta transition">
                        <option value="">-- Pilih Build --</option>
                        @foreach($savedBuilds as $build)
                            <option value="{{ $build->id }}">
                                {{ $build->name }} ({{ ucfirst($build->use_case) }}) - Rp {{ number_format($build->total_price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <p class="text-sm text-charcoal/50 text-center py-8">Belum ada build tersimpan. <a href="{{ route('welcome') }}" class="text-terracotta hover:underline">Buat build dulu</a></p>
                @endif
            @else
                <p class="text-sm text-charcoal/50 text-center py-8">Login dulu untuk akses build tersimpan. <a href="{{ route('login') }}" class="text-terracotta hover:underline">Login</a></p>
            @endif
        </div>
    @endif

    {{-- Select Komponen --}}
    @if($inputMode === 'manual')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($categories as $category)
        <div>
            <label class="block text-xs font-medium text-charcoal/50 uppercase tracking-wider mb-2">
                {{ $category->name }}
            </label>
            <select wire:model="selectedComponents.{{ $category->slug }}"
                class="w-full px-4 py-3 rounded-xl border border-charcoal/10 bg-white
                       text-charcoal text-sm focus:outline-none focus:border-terracotta transition">
                <option value="">-- Pilih {{ $category->name }} --</option>
                @foreach($category->components as $component)
                <option value="{{ $component->id }}">
                    {{ $component->name }} - Rp {{ number_format($component->base_price, 0, ',', '.') }}
                </option>
                @endforeach
            </select>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Error --}}
    @if(session('error'))
    <p class="text-sm text-red-500">{{ session('error') }}</p>
    @endif

    {{-- Button --}}
    <button wire:click="check"
        class="w-full py-4 bg-charcoal text-parchment font-medium rounded-xl hover:bg-charcoal/90 transition">
        Cek Kompatibilitas →
    </button>

    {{-- Hasil --}}
    @if($hasChecked)
    <div class="space-y-3 mt-4">
        <h3 class="text-base font-semibold text-charcoal">Hasil Pengecekan</h3>

        @foreach($results as $result)
        <div class="p-4 rounded-xl border
            @if($result['status'] === 'compatible')   border-green-200 bg-green-50
            @elseif($result['status'] === 'warning')  border-amber-200 bg-amber-50
            @else                                      border-red-200 bg-red-50
            @endif">

            {{-- Status Badge --}}
            <div class="flex items-center gap-2 mb-2">
                <span class="text-xs font-semibold uppercase tracking-wide
                    @if($result['status'] === 'compatible')   text-green-700
                    @elseif($result['status'] === 'warning')  text-amber-700
                    @else                                      text-red-700
                    @endif">
                    {{ $result['status'] === 'compatible' ? 'Kompatibel' : ($result['status'] === 'warning' ? 'Perhatian' : 'Tidak Kompatibel') }}
                </span>
            </div>

            {{-- Nama Komponen --}}
            <p class="text-sm font-medium text-charcoal">
                {{ $result['component_a'] }}
                <span class="text-charcoal/40 font-normal mx-1">↔</span>
                {{ $result['component_b'] }}
            </p>

            {{-- Pesan --}}
            <p class="text-xs mt-1
                @if($result['status'] === 'compatible')   text-green-600
                @elseif($result['status'] === 'warning')  text-amber-600
                @else                                      text-red-600
                @endif">
                {{ $result['message'] }}
            </p>

            {{-- Saran --}}
            @if($result['suggestion'])
            <p class="text-xs mt-2 font-medium
                @if($result['status'] === 'warning') text-amber-700 @else text-red-700 @endif">
                {{ $result['suggestion'] }}
            </p>
            @endif
        </div>
        @endforeach

        {{-- Summary --}}
        @php
            $totalCompatible   = collect($results)->where('status', 'compatible')->count();
            $totalWarning      = collect($results)->where('status', 'warning')->count();
            $totalIncompatible = collect($results)->where('status', 'incompatible')->count();
        @endphp
        <div class="p-4 rounded-xl bg-charcoal text-parchment flex gap-6 text-center">
            <div class="flex-1">
                <p class="text-xl font-semibold text-green-400">{{ $totalCompatible }}</p>
                <p class="text-xs opacity-50">Kompatibel</p>
            </div>
            <div class="flex-1">
                <p class="text-xl font-semibold text-amber-400">{{ $totalWarning }}</p>
                <p class="text-xs opacity-50">Perhatian</p>
            </div>
            <div class="flex-1">
                <p class="text-xl font-semibold text-red-400">{{ $totalIncompatible }}</p>
                <p class="text-xs opacity-50">Tidak Cocok</p>
            </div>
        </div>
    </div>
    @endif
</div>