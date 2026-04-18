@extends('layouts.app')
@section('title', 'Compatibility Checker')
@section('content')

    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-semibold text-charcoal">Compatibility Checker</h1>
            <p class="text-charcoal/50 mt-2">
                Pilih komponen yang ingin kamu cek dan kami akan tunjukkan apakah semuanya cocok.
            </p>
        </div>

        <div class="bg-white rounded-2xl p-8 border border-charcoal/8 shadow-sm">
            @livewire('compatibility-checker', ['buildId' => request('build')])
        </div>
    </div>

@endsection