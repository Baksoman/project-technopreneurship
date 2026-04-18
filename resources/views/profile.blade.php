@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Avatar & Name --}}
    <div class="text-center mb-6">
        <div class="w-24 h-24 rounded-full bg-terracotta/20 mx-auto mb-4 flex items-center justify-center">
            <span class="text-3xl font-bold text-terracotta">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
        </div>
        <h1 class="text-2xl font-bold text-charcoal mb-2">{{ $user->name }}</h1>
        <span class="inline-flex items-center gap-1 px-3 py-1 bg-terracotta/10 text-terracotta text-sm rounded-full">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            PC Enthusiast
        </span>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-6 border border-charcoal/10">
            <div class="flex items-center gap-2 text-terracotta mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-charcoal mb-1">{{ $buildsCount }}</div>
            <div class="text-sm text-charcoal/60">Builds Saved</div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-charcoal/10">
            <div class="flex items-center gap-2 text-terracotta mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-charcoal mb-1">{{ $memberSince }}</div>
            <div class="text-sm text-charcoal/60">Member Since</div>
        </div>
    </div>

    {{-- Menu List --}}
    <div class="bg-white rounded-2xl border border-charcoal/10 overflow-hidden mb-4">
        <a href="{{ route('my-builds') }}" class="flex items-center justify-between px-6 py-4 hover:bg-charcoal/5 transition border-b border-charcoal/10">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-terracotta/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <div>
                    <div class="font-medium text-charcoal">My Builds</div>
                    <div class="text-sm text-charcoal/60">View saved builds</div>
                </div>
            </div>
            <svg class="w-5 h-5 text-charcoal/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        <a href="#" class="flex items-center justify-between px-6 py-4 hover:bg-charcoal/5 transition border-b border-charcoal/10">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-terracotta/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-medium text-charcoal">Privacy</div>
                    <div class="text-sm text-charcoal/60">Manage your data</div>
                </div>
            </div>
            <svg class="w-5 h-5 text-charcoal/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        <a href="#" class="flex items-center justify-between px-6 py-4 hover:bg-charcoal/5 transition">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-terracotta/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-medium text-charcoal">Help & Support</div>
                    <div class="text-sm text-charcoal/60">FAQ, contact us</div>
                </div>
            </div>
            <svg class="w-5 h-5 text-charcoal/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    {{-- Sign Out --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full bg-white border border-charcoal/10 rounded-2xl px-6 py-4 text-terracotta font-medium hover:bg-terracotta/5 transition">
            Sign Out
        </button>
    </form>
</div>
@endsection
