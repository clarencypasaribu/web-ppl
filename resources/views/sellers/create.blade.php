@extends('layouts.guest')

@section('title', 'Registrasi Penjual - Sellora')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-10 bg-gradient-to-b from-purple-50 via-white to-white rounded-3xl space-y-6">
        <header class="mb-8 text-center space-y-2">
            <p class="text-xs tracking-[0.4em] uppercase text-purple-500 font-semibold">Formulir Penjual</p>
            <h1 class="text-3xl font-semibold text-purple-900">Registrasi Penjual</h1>
            <p class="text-sm text-slate-600">Isi formulir berikut. Tim admin Sellora akan memeriksa kelengkapan dokumen sebelum mengirimkan hasilnya via email.</p>
        </header>

        @if (session('status') === 'registration_submitted')
            <div class="mb-6 rounded-md bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 space-y-2">
                <p>Registrasi berhasil dikirim. Admin akan memberi tahu hasil verifikasi via email, termasuk tautan untuk membuat password bila disetujui.</p>
                <p class="text-sm">
                    Sudah daftar? <a href="{{ route('seller.login') }}" class="font-semibold underline">Login ke dashboard penjual</a>
                </p>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-md bg-rose-50 border border-rose-200 p-4 text-rose-800">
                <p class="font-medium">Periksa kembali formulir:</p>
                <ul class="list-disc ml-4 text-sm mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sellers.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-xl border border-purple-100 rounded-2xl p-6 space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="store_name" class="block font-medium mb-1 text-purple-800">Nama Toko *</label>
                    <input type="text" id="store_name" name="store_name" value="{{ old('store_name') }}" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                </div>
                <div>
                    <label for="pic_name" class="block font-medium mb-1 text-purple-800">Nama PIC *</label>
                    <input type="text" id="pic_name" name="pic_name" value="{{ old('pic_name') }}" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="pic_phone" class="block font-medium mb-1 text-purple-800">No. Handphone PIC *</label>
                    <input type="text" id="pic_phone" name="pic_phone" value="{{ old('pic_phone') }}" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                </div>
                <div>
                    <label for="pic_email" class="block font-medium mb-1 text-purple-800">Email PIC *</label>
                    <input type="email" id="pic_email" name="pic_email" value="{{ old('pic_email') }}" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                </div>
            </div>

            <div>
                <label for="short_description" class="block font-medium mb-1 text-purple-800">Deskripsi Singkat Toko</label>
                <textarea id="short_description" name="short_description" rows="3" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400">{{ old('short_description') }}</textarea>
            </div>

            <div>
                <label for="street_address" class="block font-medium mb-1 text-purple-800">Alamat Jalan *</label>
                <textarea id="street_address" name="street_address" rows="2" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>{{ old('street_address') }}</textarea>
            </div>

            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <label for="rt" class="block font-medium mb-1 text-purple-800">RT *</label>
                    <input type="text" id="rt" name="rt" value="{{ old('rt') }}" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                </div>
                <div>
                    <label for="rw" class="block font-medium mb-1 text-purple-800">RW *</label>
                    <input type="text" id="rw" name="rw" value="{{ old('rw') }}" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                </div>
                <div class="md:col-span-2">
                    <label for="ward_name" class="block font-medium mb-1 text-purple-800">Kelurahan *</label>
                    <input type="text" id="ward_name" name="ward_name" value="{{ old('ward_name') }}" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="city" class="block font-medium mb-1 text-purple-800">Kabupaten/Kota *</label>
                    <input type="text" id="city" name="city" value="{{ old('city') }}" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                </div>
                <div>
                    <label for="province" class="block font-medium mb-1 text-purple-800">Provinsi *</label>
                    <input type="text" id="province" name="province" value="{{ old('province') }}" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="pic_identity_number" class="block font-medium mb-1 text-purple-800">No. KTP PIC *</label>
                    <input type="text" id="pic_identity_number" name="pic_identity_number" value="{{ old('pic_identity_number') }}" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                </div>
                <div>
                    <label for="pic_profile_photo" class="block font-medium mb-1 text-purple-800">Foto Profil PIC *</label>
                    <input type="file" id="pic_profile_photo" name="pic_profile_photo" accept="image/*" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                    <p class="text-xs text-slate-500 mt-1">Format jpg/png, maks 2 MB.</p>
                </div>
            </div>

            <div>
                <label for="pic_identity_photo" class="block font-medium mb-1 text-purple-800">Foto KTP PIC *</label>
                <input type="file" id="pic_identity_photo" name="pic_identity_photo" accept="image/*" class="w-full border border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400" required>
                <p class="text-xs text-slate-500 mt-1">Pastikan data terlihat jelas.</p>
            </div>

            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Tanda * berarti wajib diisi.</p>
                <button type="submit" class="bg-purple-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-purple-700 shadow">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
@endsection
