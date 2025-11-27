@extends('layouts.app')

@section('title', 'Dashboard Penjual - Sellora')

@section('content')
    @php
        $productStockLabels = $productStocks->pluck('name');
        $productStockValues = $productStocks->pluck('stock');
        $ratingLabels = $productsWithAvgRating->pluck('name');
        $ratingValues = $productsWithAvgRating->pluck('reviews_avg_rating')->map(fn ($avg) => round($avg ?? 0, 2));
        $ratingCounts = $productsWithAvgRating->pluck('reviews_count');
        $provinceLabels = $ratingsByProvince->map(fn($row) => $row->province ?: 'Belum diisi');
        $provinceValues = $ratingsByProvince->pluck('total');
        $loggedSellerId = session('seller_auth_id');
    @endphp

    <div class="bg-gradient-to-b from-purple-50 via-white to-white">
        <div class="max-w-6xl mx-auto px-4 py-10 space-y-8">
            <header class="bg-white/80 backdrop-blur rounded-3xl border border-purple-100 shadow-sm p-8 space-y-6">
                <div class="flex flex-wrap justify-between items-start gap-4">
                    <div class="space-y-2">
                        <p class="text-xs tracking-[0.5em] uppercase text-purple-500 font-semibold">Sellora Insight</p>
                        <h1 class="text-3xl font-semibold text-purple-900">Dashboard Penjual</h1>
                        <p class="text-sm text-slate-600">
                            Monitor stok, performa rating, serta wilayah pelanggan untuk toko pilihan Anda.
                        </p>
                    </div>
                    @if ($loggedSellerId === $seller->id)
                    @endif
                </div>
            </header>

            @if (session('status') === 'seller_logged_in')
                <div class="rounded-md bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-700">
                    Login berhasil. Selamat datang kembali di dashboard {{ $seller->store_name }}.
                </div>
            @endif

            <section class="grid md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-purple-100 shadow-sm p-6">
                    <p class="text-sm text-slate-500">Total Produk</p>
                    <p class="text-3xl font-semibold mt-2 text-purple-900">{{ $productStocks->count() }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-purple-100 shadow-sm p-6">
                    <p class="text-sm text-slate-500">Jumlah Rating</p>
                    <p class="text-3xl font-semibold mt-2 text-purple-900">{{ $ratingCounts->sum() }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-purple-100 shadow-sm p-6">
                    <p class="text-sm text-slate-500">Jumlah Kategori</p>
                    <p class="text-3xl font-semibold mt-2 text-purple-900">{{ $categoriesCount }}</p>
                </div>
            </section>

            <section class="grid md:grid-cols-2 gap-6">
                <div class="bg-white rounded-3xl border border-purple-100 shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-lg font-semibold text-purple-900">Sebaran Stok per Produk</h2>
                            <p class="text-xs text-slate-500">Menemukan produk dengan stok menipis.</p>
                        </div>
                    </div>
                    <canvas id="productStockChart" height="240"></canvas>
                </div>
                <div class="bg-white rounded-3xl border border-purple-100 shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-lg font-semibold text-purple-900">Nilai Rating per Produk</h2>
                            <p class="text-xs text-slate-500">Rata-rata rating dengan jumlah review.</p>
                        </div>
                    </div>
                    <canvas id="productRatingChart" height="240"></canvas>
                </div>
            </section>

            <section class="bg-white rounded-3xl border border-purple-100 shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-purple-900">Sebaran Pemberi Rating per Provinsi</h2>
                        <p class="text-xs text-slate-500">Mengetahui jangkauan pelanggan.</p>
                    </div>
                </div>
                <div class="max-w-2xl mx-auto">
                    <canvas id="ratingProvinceChart" height="260"></canvas>
                </div>
            </section>

            <section class="bg-white rounded-3xl border border-purple-100 shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-purple-900">Komentar Terbaru per Produk</h2>
                        <p class="text-xs text-slate-500">Pantau masukan pembeli untuk tiap produk.</p>
                    </div>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($recentReviewsByProduct as $product)
                        <div class="py-4">
                            <div class="flex justify-between items-start">
                                <h3 class="text-sm font-semibold text-purple-900">{{ $product->name }}</h3>
                                <span class="text-xs text-slate-500">{{ $product->reviews->count() }} komentar terbaru</span>
                            </div>
                            <ul class="mt-2 space-y-2">
                                @forelse ($product->reviews as $review)
                                    <li class="text-sm text-slate-700 bg-slate-50 border border-slate-100 rounded-lg p-3">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-semibold text-slate-900">{{ $review->reviewer_name }}</span>
                                            <span class="text-xs text-amber-600">Rating: {{ $review->rating }}/5</span>
                                        </div>
                                        <p class="text-sm text-slate-600">{{ $review->comment ?: 'Tidak ada komentar tertulis.' }}</p>
                                    </li>
                                @empty
                                    <li class="text-sm text-slate-500">Belum ada komentar.</li>
                                @endforelse
                            </ul>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada produk.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stockCtx = document.getElementById('productStockChart');
            if (stockCtx) {
                new Chart(stockCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($productStockLabels),
                        datasets: [{
                            label: 'Stok',
                            data: @json($productStockValues),
                            backgroundColor: '#4f46e5'
                        }]
                    },
                    options: {
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }

            const ratingCtx = document.getElementById('productRatingChart');
            if (ratingCtx) {
                new Chart(ratingCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($ratingLabels),
                        datasets: [{
                            type: 'bar',
                            label: 'Rata-rata Rating',
                            data: @json($ratingValues),
                            backgroundColor: '#f59e0b'
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 5
                            },
                            y1: {
                                position: 'right',
                                beginAtZero: true,
                                grid: { drawOnChartArea: false }
                            }
                        }
                    }
                });
            }

            const provinceCtx = document.getElementById('ratingProvinceChart');
            if (provinceCtx) {
                new Chart(provinceCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($provinceLabels),
                        datasets: [{
                            data: @json($provinceValues),
                            backgroundColor: ['#4f46e5', '#0ea5e9', '#10b981', '#f59e0b', '#ec4899', '#14b8a6', '#6366f1']
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });
            }
        });
    </script>
@endpush
