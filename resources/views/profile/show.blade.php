@extends('layouts.app')

@section('title', 'Detail Profil Penjual')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 py-8">
        <div class="bg-white rounded-3xl border border-purple-100 shadow-sm p-6 space-y-4">
            <h1 class="text-3xl font-semibold text-purple-900">Profil {{ $seller->store_name }}</h1>
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
                <div>
                    <dt class="text-slate-500">Status</dt>
                    <dd class="font-semibold text-slate-900">{{ ucfirst($seller->status) }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Nomor KTP PIC</dt>
                    <dd class="font-semibold text-slate-900">{{ $seller->pic_identity_number }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-3xl border border-purple-100 shadow-sm p-6 space-y-3">
            <h2 class="text-xl font-semibold text-purple-900">Alamat & Deskripsi</h2>
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
        </div>

        <div class="bg-white rounded-3xl border border-purple-100 shadow-sm p-6 space-y-4">
            <h2 class="text-xl font-semibold text-purple-900">Dokumen</h2>
            <ul class="text-sm text-slate-600 space-y-2">
                <li>Foto Profil PIC: {{ $seller->pic_profile_photo ? 'Sudah diunggah' : 'Belum ada' }}</li>
                <li>Foto KTP PIC: {{ $seller->pic_identity_photo ? 'Sudah diunggah' : 'Belum ada' }}</li>
            </ul>
        </div>
    </div>
@endsection
