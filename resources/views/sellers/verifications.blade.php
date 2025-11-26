@extends('layouts.app')

@section('title', 'Verifikasi Penjual - MartPlace')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
    @endphp
    <div class="max-w-6xl mx-auto px-4 py-10">
        <header class="mb-6 flex items-center justify-between flex-wrap gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-slate-500 font-semibold">Admin Only</p>
                <h1 class="text-3xl font-semibold">Dashboard Verifikasi</h1>
                <p class="text-sm text-slate-600 mt-1">
                    Cek kelengkapan administrasi calon penjual. Kirimkan hasil verifikasi agar notifikasi email (diterima/ditolak) langsung diterima PIC.
                </p>
            </div>
            <div class="flex gap-3 items-center">
                <a href="{{ route('dashboard.platform') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Dashboard Platform →</a>
                <a href="{{ route('sellers.register') }}" class="text-sm text-slate-600 hover:text-slate-800">Kembali ke formulir registrasi</a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-rose-600 hover:text-rose-800">Logout Admin</button>
                </form>
            </div>
        </header>

        @if (session('status') === 'seller_verified')
            <div class="mb-4 rounded-md bg-emerald-50 border border-emerald-200 p-4 text-emerald-800">
                Status penjual berhasil diperbarui dan notifikasi email telah dikirim.
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-rose-50 border border-rose-200 p-4 text-rose-800">
                <p class="font-medium">Gagal memproses verifikasi:</p>
                <ul class="list-disc ml-4 text-sm mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($sellers->isEmpty())
            <div class="text-center py-16 bg-white rounded-xl shadow">
                <p class="text-lg font-medium">Belum ada pengajuan penjual.</p>
                <p class="text-sm text-slate-500">Minta calon penjual mengisi formulir registrasi terlebih dahulu.</p>
            </div>
        @else
            <div class="bg-white shadow rounded-xl p-5">
                <h2 class="text-lg font-semibold mb-4">Daftar Pengajuan</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-slate-100 rounded-lg">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left">Nama Toko</th>
                                <th class="px-4 py-3 text-left">PIC</th>
                                <th class="px-4 py-3 text-left">Email PIC</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @foreach ($sellers as $seller)
                                @php
                                    $badge = match ($seller->status) {
                                        \App\Models\Seller::STATUS_APPROVED => 'bg-emerald-100 text-emerald-700',
                                        \App\Models\Seller::STATUS_REJECTED => 'bg-rose-100 text-rose-700',
                                        default => 'bg-amber-100 text-amber-700',
                                    };
                                @endphp
                                <tr>
                                    <td class="px-4 py-3 font-medium">{{ $seller->store_name }}</td>
                                    <td class="px-4 py-3">{{ $seller->pic_name }}</td>
                                    <td class="px-4 py-3">{{ $seller->pic_email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                            {{ strtoupper($seller->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="#seller-{{ $seller->id }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-4 mt-8">
                @foreach ($sellers as $seller)
                    <div id="seller-{{ $seller->id }}" class="bg-white shadow rounded-xl p-5">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Pengajuan</p>
                                <h2 class="text-xl font-semibold">{{ $seller->store_name }}</h2>
                                <p class="text-sm text-slate-500">{{ $seller->short_description ?? 'Belum ada deskripsi singkat.' }}</p>
                                @php
                                    $badge = match ($seller->status) {
                                        \App\Models\Seller::STATUS_APPROVED => 'bg-emerald-100 text-emerald-700',
                                        \App\Models\Seller::STATUS_REJECTED => 'bg-rose-100 text-rose-700',
                                        default => 'bg-amber-100 text-amber-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mt-2 {{ $badge }}">
                                    Status: {{ strtoupper($seller->status) }}
                                </span>
                            </div>
                            <div class="text-sm text-slate-500">
                                <p class="font-medium text-slate-700">PIC</p>
                                <p>{{ $seller->pic_name }}</p>
                                <p>{{ $seller->pic_phone }} · {{ $seller->pic_email }}</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-3 gap-4 text-sm mt-4">
                            <div>
                                <p class="font-medium text-slate-700">Alamat</p>
                                <p>{{ $seller->street_address }}</p>
                                <p>RT {{ $seller->rt }} / RW {{ $seller->rw }}, Kel. {{ $seller->ward_name }}</p>
                                <p>{{ $seller->city }}, {{ $seller->province }}</p>
                            </div>
                            <div>
                                <p class="font-medium text-slate-700">Data Administrasi</p>
                                <p>No. KTP: {{ $seller->pic_identity_number }}</p>
                                <div class="flex flex-col gap-1 mt-1">
                                    @if ($seller->pic_identity_photo_path)
                                        <a class="text-indigo-600 hover:text-indigo-800" href="{{ Storage::url($seller->pic_identity_photo_path) }}" target="_blank">Lihat Foto KTP</a>
                                    @endif
                                    @if ($seller->pic_profile_photo_path)
                                        <a class="text-indigo-600 hover:text-indigo-800" href="{{ Storage::url($seller->pic_profile_photo_path) }}" target="_blank">Lihat Foto Profil PIC</a>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="font-medium text-slate-700">Catatan</p>
                                <p>{{ $seller->verification_notes ?? 'Belum ada catatan verifikasi.' }}</p>
                                @if ($seller->verified_at)
                                    <p class="mt-1 text-slate-500">Diperbarui: {{ $seller->verified_at->format('d M Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('sellers.verify', $seller) }}" method="POST" class="mt-6 border-t border-slate-100 pt-4 grid md:grid-cols-3 gap-4">
                            @csrf
                            <div>
                                <label for="status-{{ $seller->id }}" class="block text-sm font-medium text-slate-700 mb-1">Hasil Verifikasi *</label>
                                <select id="status-{{ $seller->id }}" name="status" class="w-full border-slate-300 rounded-lg">
                                    <option value="{{ \App\Models\Seller::STATUS_APPROVED }}" @selected($seller->status === \App\Models\Seller::STATUS_APPROVED)>Diterima</option>
                                    <option value="{{ \App\Models\Seller::STATUS_REJECTED }}" @selected($seller->status === \App\Models\Seller::STATUS_REJECTED)>Ditolak</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="notes-{{ $seller->id }}" class="block text-sm font-medium text-slate-700 mb-1">
                                    Catatan (wajib jika ditolak)
                                </label>
                                <textarea id="notes-{{ $seller->id }}" name="verification_notes" rows="2" class="w-full border-slate-300 rounded-lg">{{ old('verification_notes', $seller->verification_notes) }}</textarea>
                            </div>
                            <div class="md:col-span-3 flex justify-end">
                                <button type="submit" class="bg-indigo-600 text-white font-medium px-5 py-2 rounded-lg hover:bg-indigo-700">
                                    Kirim Notifikasi Email
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
