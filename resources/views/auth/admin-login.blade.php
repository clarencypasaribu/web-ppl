@extends('layouts.guest')

@section('title', 'Login Admin - Sellora')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4 bg-gradient-to-b from-purple-50 to-white">
        <div class="bg-white shadow-xl rounded-2xl max-w-md w-full p-8 space-y-6 border border-purple-100">
            <div class="text-center space-y-2">
                <p class="text-xs tracking-[0.4em] uppercase text-purple-500 font-semibold">Sellora Admin</p>
                <h1 class="text-3xl font-semibold text-purple-900">Login Admin</h1>
                <p class="text-sm text-slate-600">Masukkan passcode admin untuk mengakses dashboard verifikasi.</p>
            </div>

            @if ($errors->any())
                <div class="rounded-md bg-rose-50 border border-rose-200 p-3 text-sm text-rose-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('status') === 'admin_logged_out')
                <div class="rounded-md bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">
                    Anda telah keluar dari sesi admin.
                </div>
            @endif

            <form action="{{ route('admin.login.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label for="passcode" class="block text-sm font-medium text-purple-800">Passcode Admin</label>
                    <input type="password" name="passcode" id="passcode" class="w-full border-purple-200 focus:border-purple-400 focus:ring-purple-400 rounded-lg" required autofocus>
                </div>
                <button type="submit" class="w-full bg-purple-700 text-white font-semibold py-3 rounded-lg hover:bg-purple-800 shadow">
                    Login sebagai Admin
                </button>
            </form>
        </div>
    </div>
@endsection
