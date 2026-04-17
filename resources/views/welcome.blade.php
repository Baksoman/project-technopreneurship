@extends('layouts.app')
@section('title', 'Home')
@section('content')

{{-- Hero --}}
<div class="text-center max-w-xl mx-auto mb-12">
    <span class="inline-block px-3 py-1 rounded-full bg-terracotta/10
                 text-terracotta text-xs font-medium mb-4">
        PC Builder Assistant
    </span>
    <h1 class="text-4xl font-semibold text-charcoal leading-tight mb-4">
        Rakit PC impian kamu,<br>tanpa pusing riset berjam-jam.
    </h1>
    <p class="text-charcoal/50 leading-relaxed">
        Masukkan budget dan kebutuhan — Buildr rekomendasikan build terbaik,
        cek kompatibilitas, dan bandingkan harga secara otomatis.
    </p>
</div>

{{-- Recommender Card --}}
<div class="max-w-2xl mx-auto bg-white rounded-2xl p-8 border border-charcoal/8 shadow-sm">
    <h2 class="text-base font-semibold text-charcoal mb-6">
        Temukan build terbaik kamu 👇
    </h2>
    @livewire('build-recommender')
</div>

@endsection