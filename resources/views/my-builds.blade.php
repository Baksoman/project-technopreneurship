@extends('layouts.app')
@section('title', 'My Builds')
@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-charcoal">My Builds</h1>
        <p class="text-charcoal/50 mt-2">
            Semua build yang sudah kamu simpan
        </p>
    </div>

    @livewire('my-builds')
</div>

@endsection
