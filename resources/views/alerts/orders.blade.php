@extends('layouts.app')

@section('title', 'Alert Pesanan - Sellora')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6 py-6">
        <header class="space-y-2 text-center">
            <p class="text-xs tracking-[0.4em] uppercase text-purple-500 font-semibold">Orders Alert</p>
            <h1 class="text-3xl font-semibold text-purple-900">Komentar & Rating Terbaru</h1>
            <p class="text-slate-600 text-sm">Pantau notifikasi dari pengunjung yang menilai produk Anda di landing page katalog.</p>
        </header>

        <section class="bg-white rounded-2xl border border-purple-100 shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-purple-50 text-purple-700 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-4 py-3 text-left">Pengunjung</th>
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-left">Komentar</th>
                        <th class="px-4 py-3 text-center">Rating</th>
                        <th class="px-4 py-3 text-right">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($reviews as $review)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-800">
                                {{ $review->reviewer_name }}
                                <span class="block text-xs text-slate-400">{{ $review->province ?: 'Domisili tidak diisi' }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $review->product->name ?? '-' }}
                                <span class="block text-xs text-slate-400">{{ $review->product->seller->store_name ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $review->comment ?: 'Tidak ada komentar' }}
                            </td>
                            <td class="px-4 py-3 text-center text-amber-500 font-semibold">{{ $review->rating }}/5</td>
                            <td class="px-4 py-3 text-right text-slate-500">{{ $review->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada komentar atau rating baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
@endsection
