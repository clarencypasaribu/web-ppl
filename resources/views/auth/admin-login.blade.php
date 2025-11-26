@extends('layouts.app')

@section('title', 'Login Admin - MartPlace')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4">
        <div class="bg-white shadow-xl rounded-2xl max-w-md w-full p-8 space-y-6">
            <div class="text-center space-y-2">
                <p class="text-xs tracking-[0.4em] uppercase text-slate-500 font-semibold">MartPlace</p>
                <h1 class="text-3xl font-semibold">Login Admin</h1>
                <p class="text-sm text-slate-600">Masukkan passcode admin (ENV <code>ADMIN_VERIFICATION_PASSCODE</code>) untuk mengakses dashboard verifikasi.</p>
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
                    <label for="passcode" class="block text-sm font-medium text-slate-700">Passcode Admin</label>
                    <input type="password" name="passcode" id="passcode" class="w-full border-slate-300 rounded-lg" required autofocus>
                </div>
                <button type="submit" class="w-full bg-slate-900 text-white font-semibold py-3 rounded-lg hover:bg-slate-800">
                    Login sebagai Admin
                </button>
            </form>
        </div>
    </div>
@endsection
