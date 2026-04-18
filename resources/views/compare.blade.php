@extends('layouts.app')
@section('title', 'Build Comparison')
@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-charcoal">Build Comparison</h1>
        <p class="text-charcoal/50 mt-2">
            Bandingkan dua build berbeda - lihat mana yang paling worth it untuk kebutuhanmu.
        </p>
    </div>

    @livewire('build-comparison', ['buildIdA' => request('buildA')])
</div>

@endsection