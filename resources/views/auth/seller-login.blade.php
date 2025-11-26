@extends('layouts.guest')

@section('title', 'Login Penjual - Sellora')

@section('content')
    <div class="min-h-[80vh] flex flex-col items-center justify-center px-4 bg-gradient-to-b from-purple-50 to-white">
        <div class="bg-white shadow-xl rounded-2xl max-w-md w-full p-8 space-y-6 border border-purple-100">
            <div class="text-center space-y-2">
                <p class="text-xs tracking-[0.4em] uppercase text-purple-500 font-semibold">Sellora</p>
                <h1 class="text-3xl font-semibold text-purple-900">Login Penjual</h1>
                <p class="text-sm text-slate-600">Masuk menggunakan email PIC dan password yang dibuat setelah verifikasi admin.</p>
            </div>

            @if ($errors->any())
                <div class="rounded-md bg-rose-50 border border-rose-200 p-3 text-sm text-rose-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('status') === 'seller_logged_out')
                <div class="rounded-md bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">
                    Anda telah keluar dari sesi penjual.
                </div>
            @endif
            @if (session('status') === 'password_created')
                <div class="rounded-md bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">
                    Password berhasil dibuat. Silakan login menggunakan kredensial baru.
                </div>
            @endif
            @if (session('status') === 'password_already_set')
                <div class="rounded-md bg-amber-50 border border-amber-200 p-3 text-sm text-amber-700">
                    Password sudah pernah dibuat. Gunakan password tersebut untuk login.
                </div>
            @endif

            <form action="{{ route('seller.login.attempt') }}" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-1">
                    <label for="pic_email" class="block text-sm font-medium text-purple-800">Email PIC *</label>
                    <input type="email" id="pic_email" name="pic_email" value="{{ old('pic_email', session('prefill_email')) }}" class="w-full border-purple-200 focus:border-purple-400 focus:ring-purple-400 rounded-lg" required autofocus>
                </div>
                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-purple-800">Password *</label>
                    <input type="password" id="password" name="password" class="w-full border-purple-200 focus:border-purple-400 focus:ring-purple-400 rounded-lg" required>
                    <p class="text-xs text-slate-500">Jika belum memiliki password, cek email persetujuan admin untuk membuatnya.</p>
                </div>
                <button type="submit" class="w-full bg-purple-600 text-white font-semibold py-3 rounded-lg hover:bg-purple-700 shadow">
                    Masuk
                </button>
            </form>

            <div class="text-center text-sm text-slate-500">
                Belum punya akun? <a href="{{ route('sellers.register') }}" class="text-purple-600 hover:text-purple-800 font-semibold">Registrasi penjual</a>
            </div>
        </div>
    </div>
@endsection
