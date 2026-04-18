<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-50 border border-green-200">
            <p class="text-sm text-green-600">{{ session('success') }}</p>
        </div>
    @endif

    @if($builds->isEmpty())
        <div class="text-center py-12">
            <p class="text-charcoal/50 mb-4">Belum ada build tersimpan</p>
            <a href="/" class="inline-block px-6 py-3 bg-terracotta text-white rounded-xl hover:bg-terracotta/90 transition">
                Buat Build Pertama
            </a>
        </div>
    @else
        <div class="grid gap-4">
            @foreach($builds as $build)
                <div class="bg-white rounded-xl p-6 border border-charcoal/8">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-charcoal">{{ $build->name }}</h3>
                            <p class="text-sm text-charcoal/50 mt-1">
                                {{ ucfirst($build->use_case) }} • 
                                {{ $build->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-semibold text-terracotta">
                                {{ $build->performance_score }}<span class="text-sm text-charcoal/30">/100</span>
                            </p>
                            <p class="text-sm text-charcoal/50">Rp {{ number_format($build->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="space-y-2 mb-4">
                        @foreach($build->components->groupBy('category.slug') as $slug => $components)
                            @foreach($components as $component)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-charcoal/50 uppercase text-xs font-medium">{{ $slug }}</span>
                                    <span class="text-charcoal">{{ $component->name }}</span>
                                </div>
                            @endforeach
                        @endforeach
                    </div>

                    <div class="flex gap-2">
                        <a href="/compatibility?build={{ $build->id }}" 
                           class="flex-1 py-2 text-center text-sm border border-charcoal/20 rounded-lg hover:bg-charcoal/5 transition">
                            Cek Kompatibilitas
                        </a>
                        <a href="/compare?buildA={{ $build->id }}" 
                           class="flex-1 py-2 text-center text-sm border border-charcoal/20 rounded-lg hover:bg-charcoal/5 transition">
                            Bandingkan
                        </a>
                        <button wire:click="deleteBuild('{{ $build->id }}')" 
                                wire:confirm="Yakin mau hapus build ini?"
                                class="px-4 py-2 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
