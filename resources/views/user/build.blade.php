@extends('layouts.app')
@section('title', 'Home')
@section('content')

{{-- Hero --}}
<div class="text-center max-w-xl mx-auto mb-12">
    <h1 class="text-4xl font-semibold text-charcoal leading-tight mb-4">
        Rakit PC sesuai kebutuhanmu,<br>tanpa pusing riset berjam-jam.
    </h1>
    <p class="text-charcoal/50 leading-relaxed">
        Masukkan budget dan kebutuhanmu, Buildr akan merekomendasikan build terbaik,
        cek kompatibilitas, dan bandingkan harga secara otomatis.
    </p>
</div>

{{-- Recommender Card --}}
<div class="max-w-2xl mx-auto bg-white rounded-2xl p-8 border border-charcoal/8 shadow-sm">
    <h2 class="text-xl md:text-3xl font-bold text-center text-charcoal mb-10">
        Smart Builder
    </h2>
    @livewire('user.build-recommender')
</div>

@endsection