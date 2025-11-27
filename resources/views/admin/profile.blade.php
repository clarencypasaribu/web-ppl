@extends('layouts.app')

@section('title', 'Profil Admin - Sellora')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10 space-y-6">
        <header class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Profil</p>
                <h1 class="text-3xl font-semibold text-slate-900">Admin Platform</h1>
                <p class="text-sm text-slate-600">Detail akun dan hak akses saat ini.</p>
            </div>
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Logged in
            </span>
        </header>

        <section class="bg-white rounded-xl shadow p-5 space-y-4">
            <div class="flex flex-wrap items-center gap-3 justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-500">Nama</p>
                    <p class="text-xl font-semibold text-slate-900">{{ $profile['name'] }}</p>
                    <p class="text-sm text-purple-700 font-medium">{{ $profile['role'] }}</p>
                </div>
                <a href="{{ route('dashboard.platform') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white text-sm rounded-lg hover:bg-slate-800 transition">
                    Lihat Dashboard
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <dl class="grid md:grid-cols-3 gap-3 text-sm text-slate-700">
                <div class="bg-slate-50 rounded-lg p-4">
                    <dt class="text-xs uppercase tracking-wide text-slate-500">Login waktu</dt>
                    <dd class="mt-1 font-semibold">{{ $profile['logged_in_at'] ?? '-' }}</dd>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <dt class="text-xs uppercase tracking-wide text-slate-500">Email kontak</dt>
                    <dd class="mt-1 font-semibold">{{ $profile['contact'] }}</dd>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <dt class="text-xs uppercase tracking-wide text-slate-500">Hak akses</dt>
                    <dd class="mt-1 font-semibold">Admin Platform</dd>
                </div>
            </dl>

            <div class="bg-slate-50 rounded-lg p-4">
                <p class="text-xs uppercase tracking-wide text-slate-500 mb-2">Ruang Lingkup</p>
                <ul class="space-y-1 text-sm text-slate-700 list-disc list-inside">
                    @foreach($profile['scopes'] as $scope)
                        <li>{{ $scope }}</li>
                    @endforeach
                </ul>
            </div>
        </section>
    </div>
@endsection
