@extends('layouts.app')

@section('title', 'Buat Password Penjual - MartPlace')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4">
        <div class="bg-white shadow-xl rounded-2xl max-w-md w-full p-8 space-y-6">
            <div class="text-center space-y-2">
                <p class="text-xs tracking-[0.4em] uppercase text-indigo-500 font-semibold">MartPlace</p>
                <h1 class="text-3xl font-semibold">Buat Password Penjual</h1>
                <p class="text-sm text-slate-600">
                    Akun untuk <span class="font-semibold">{{ $seller->store_name }}</span> telah disetujui. Silakan buat password minimal 8 karakter untuk login ke dashboard penjual.
                </p>
            </div>

            @if ($errors->any())
                <div class="rounded-md bg-rose-50 border border-rose-200 p-3 text-sm text-rose-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ $storeUrl }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-slate-700">Password Baru *</label>
                    <input type="password" id="password" name="password" class="w-full border-slate-300 rounded-lg" minlength="8" required autofocus>
                </div>
                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full border-slate-300 rounded-lg" minlength="8" required>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700">
                    Simpan Password
                </button>
            </form>

            <p class="text-center text-xs text-slate-500">Link ini hanya berlaku 7 hari sejak email persetujuan diterima.</p>
        </div>
    </div>
@endsection
