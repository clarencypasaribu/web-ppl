@extends('layouts.app')

@section('title', 'Profil Saya - Penjual')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10 space-y-6">
        <header class="flex items-start justify-between gap-4 flex-wrap">
            <div>
                <p class="text-xs uppercase tracking-wide text-purple-500 font-semibold">Profil Penjual</p>
                <h1 class="text-3xl font-semibold text-purple-900">{{ $seller->store_name }}</h1>
                <p class="text-sm text-slate-600">Kelola informasi akun, kontak PIC, dan alamat toko.</p>
            </div>
            <a href="{{ route('dashboard.seller', $seller) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white text-sm rounded-lg hover:bg-slate-800 transition">
                Kembali ke Dashboard
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </header>

        <section class="bg-white rounded-2xl border border-purple-100 shadow-sm p-6 space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-500">Status Akun</p>
                    <p class="text-lg font-semibold text-purple-900">{{ ucfirst($seller->status) }}</p>
                </div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Aktif
                </span>
            </div>
            <dl class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-slate-500">Nama Toko</dt>
                    <dd class="font-semibold text-slate-900">{{ $seller->store_name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Nama PIC</dt>
                    <dd class="font-semibold text-slate-900">{{ $seller->pic_name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Email PIC</dt>
                    <dd class="font-semibold text-slate-900">{{ $seller->pic_email }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Nomor HP PIC</dt>
                    <dd class="font-semibold text-slate-900">{{ $seller->pic_phone }}</dd>
                </div>
            </dl>
        </section>

        <section class="bg-white rounded-2xl border border-purple-100 shadow-sm p-6 space-y-3">
            <h2 class="text-lg font-semibold text-purple-900">Alamat & Deskripsi</h2>
            <dl class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-slate-500">Alamat Jalan</dt>
                    <dd class="font-semibold text-slate-900">{{ $seller->street_address }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">RT / RW</dt>
                    <dd class="font-semibold text-slate-900">{{ $seller->rt }} / {{ $seller->rw }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Kelurahan</dt>
                    <dd class="font-semibold text-slate-900">{{ $seller->ward_name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Kota / Provinsi</dt>
                    <dd class="font-semibold text-slate-900">{{ $seller->city }}, {{ $seller->province }}</dd>
                </div>
            </dl>
            <div>
                <dt class="text-slate-500">Deskripsi Toko</dt>
                <dd class="font-semibold text-slate-900">{{ $seller->short_description ?: 'Belum ada deskripsi.' }}</dd>
            </div>
        </section>

        <section class="bg-white rounded-2xl border border-purple-100 shadow-sm p-6 space-y-3">
            <h2 class="text-lg font-semibold text-purple-900">Dokumen</h2>
            <ul class="text-sm text-slate-600 space-y-2">
                <li>Foto Profil PIC: {{ $seller->pic_profile_photo_path ? 'Sudah diunggah' : 'Belum ada' }}</li>
                <li>Foto KTP PIC: {{ $seller->pic_identity_photo_path ? 'Sudah diunggah' : 'Belum ada' }}</li>
            </ul>
        </section>

        <section class="bg-white rounded-2xl border border-purple-100 shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-500">Ringkasan Aktivitas</p>
                    <p class="text-lg font-semibold text-purple-900">Produk Terdaftar</p>
                </div>
                <span class="text-2xl font-semibold text-purple-900">{{ $seller->products_count }}</span>
            </div>
        </section>
    </div>
@endsection
