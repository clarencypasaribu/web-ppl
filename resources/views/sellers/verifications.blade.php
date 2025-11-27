@extends('layouts.app')

@section('title', 'Verifikasi Penjual - Sellora')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
    @endphp
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-6">
        <header class="bg-white border border-purple-100 rounded-2xl shadow-sm p-6 space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.35em] text-purple-500 font-semibold">Verifikasi Penjual</p>
                    <h1 class="text-3xl font-semibold text-purple-900">Calon Penjual Menunggu Persetujuan</h1>
                    <p class="text-sm text-slate-600">
                        Cek kelengkapan administrasi, pastikan dokumen valid, lalu kirim notifikasi hasil verifikasi ke PIC.
                    </p>
                </div>
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
            <div class="bg-white shadow rounded-2xl p-5 border border-slate-100">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Daftar Pengajuan</h2>
                        <p class="text-sm text-slate-500">Urutkan dan buka detail untuk memproses.</p>
                    </div>
                    <span class="text-xs bg-slate-100 text-slate-700 px-3 py-1 rounded-full font-semibold">
                        Total: {{ $sellers->count() }} pengajuan
                    </span>
                </div>
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
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $seller->store_name }}</td>
                                    <td class="px-4 py-3 text-slate-700">{{ $seller->pic_name }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $seller->pic_email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                            {{ strtoupper($seller->status) }}
                                        </span>
                                    </td>
                                <td class="px-4 py-3">
                                    <button
                                        type="button"
                                        class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold"
                                        data-detail-target="seller-{{ $seller->id }}"
                                    >
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-4 mt-8">
            @foreach ($sellers as $seller)
                <div id="seller-{{ $seller->id }}" class="hidden">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div class="space-y-1">
                                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Pengajuan</p>
                                <h2 class="text-xl font-semibold text-slate-900">{{ $seller->store_name }}</h2>
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
                            <div class="text-sm text-slate-500 min-w-[220px]">
                                <p class="font-semibold text-slate-800">PIC</p>
                                <p>{{ $seller->pic_name }}</p>
                                <p>{{ $seller->pic_phone }} · {{ $seller->pic_email }}</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-3 gap-4 text-sm">
                            <div class="space-y-1">
                                <p class="font-semibold text-slate-800">Alamat</p>
                                <p>{{ $seller->street_address }}</p>
                                <p>RT {{ $seller->rt }} / RW {{ $seller->rw }}, Kel. {{ $seller->ward_name }}</p>
                                <p>{{ $seller->city }}, {{ $seller->province }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="font-semibold text-slate-800">Data Administrasi</p>
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
                            <div class="space-y-1">
                                <p class="font-semibold text-slate-800">Catatan</p>
                                <p>{{ $seller->verification_notes ?? 'Belum ada catatan verifikasi.' }}</p>
                                @if ($seller->verified_at)
                                    <p class="mt-1 text-slate-500">Diperbarui: {{ $seller->verified_at->format('d M Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('sellers.verify', $seller) }}" method="POST" class="border-t border-slate-100 pt-4 grid md:grid-cols-3 gap-4">
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
                                <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm hover:bg-indigo-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.75 10a.75.75 0 0 1 .75-.75h7.69L8.22 6.28a.75.75 0 0 1 1.06-1.06l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06l2.97-2.97H3.5A.75.75 0 0 1 2.75 10Z" />
                                        <path d="M16.25 3.5a.75.75 0 0 1 .75.75v11.5a.75.75 0 0 1-1.5 0V4.25a.75.75 0 0 1 .75-.75Z" />
                                    </svg>
                                    Kirim Notifikasi Email
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>

    @push('scripts')
        <script>
            const detailButtons = document.querySelectorAll('[data-detail-target]');
            const modalBackdrop = document.createElement('div');
            modalBackdrop.className = 'fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 px-4 py-6';

            const modalCard = document.createElement('div');
            modalCard.className = 'w-full max-w-3xl bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden';
            modalBackdrop.appendChild(modalCard);

            document.body.appendChild(modalBackdrop);

            function closeModal() {
                modalBackdrop.classList.add('hidden');
                modalCard.innerHTML = '';
            }

            modalBackdrop.addEventListener('click', (event) => {
                if (event.target === modalBackdrop) {
                    closeModal();
                }
            });

            detailButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-detail-target');
                    const template = document.getElementById(targetId);
                    if (!template) return;

                    modalCard.innerHTML = `
                        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                            <div class="space-y-1">
                                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Detail Pengajuan</p>
                                <h3 class="text-lg font-semibold text-slate-900">Verifikasi Penjual</h3>
                            </div>
                            <button class="text-slate-500 hover:text-slate-700" aria-label="Tutup detail" id="modalCloseBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.22 4.22a.75.75 0 0 1 1.06 0L10 8.94l4.72-4.72a.75.75 0 1 1 1.06 1.06L11.06 10l4.72 4.72a.75.75 0 1 1-1.06 1.06L10 11.06l-4.72 4.72a.75.75 0 1 1-1.06-1.06L8.94 10 4.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div class="p-5 max-h-[80vh] overflow-y-auto space-y-4">
                            ${template.innerHTML}
                        </div>
                    `;

                    modalBackdrop.classList.remove('hidden');

                    const closeBtn = modalCard.querySelector('#modalCloseBtn');
                    closeBtn?.addEventListener('click', closeModal);
                });
            });
        </script>
    @endpush
@endsection
