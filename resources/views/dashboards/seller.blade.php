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

    <div class="max-w-6xl mx-auto px-4 py-10 space-y-6">
        <header class="space-y-3">
            <div class="flex flex-wrap justify-between items-start gap-4">
                <div>
                    <h1 class="text-3xl font-semibold">Dashboard Penjual (SRS-Sellora-08)</h1>
                    <p class="text-sm text-slate-600">
                        Monitor stok produk, nilai rating, serta lokasi pemberi rating untuk toko pilihan.
                    </p>
                </div>
                @if ($loggedSellerId === $seller->id)
                    <form action="{{ route('seller.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-rose-600 hover:text-rose-800">Keluar</button>
                    </form>
                @endif
            </div>
            <div class="flex flex-wrap gap-3 items-center">
                <label for="sellerSwitcher" class="text-sm font-medium text-slate-700">Pilih toko:</label>
                <select id="sellerSwitcher" class="border-slate-300 rounded-lg text-sm py-2">
                    @foreach ($allSellers as $sellerOption)
                        <option value="{{ route('dashboard.seller', $sellerOption) }}" @selected($sellerOption->id === $seller->id)>
                            {{ $sellerOption->store_name }} ({{ ucfirst($sellerOption->status) }})
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Kelola Produk →</a>
            </div>
        </header>

        @if (session('status') === 'seller_logged_in')
            <div class="rounded-md bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-700">
                Login berhasil. Selamat datang kembali di dashboard {{ $seller->store_name }}.
            </div>
        @endif

        <section class="grid md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-sm text-slate-500">Total Produk</p>
                <p class="text-3xl font-semibold mt-2">{{ $productStocks->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-sm text-slate-500">Total Stok</p>
                <p class="text-3xl font-semibold mt-2">{{ $productStockValues->sum() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-sm text-slate-500">Jumlah Review</p>
                <p class="text-3xl font-semibold mt-2">{{ $ratingCounts->sum() }}</p>
            </div>
        </section>

        <section class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-5">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-semibold">Sebaran Stok per Produk</h2>
                        <p class="text-xs text-slate-500">Menemukan produk dengan stok menipis.</p>
                    </div>
                </div>
                <canvas id="productStockChart" height="240"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-semibold">Nilai Rating per Produk</h2>
                        <p class="text-xs text-slate-500">Rata-rata rating dengan jumlah review.</p>
                    </div>
                </div>
                <canvas id="productRatingChart" height="240"></canvas>
            </div>
        </section>

        <section class="bg-white rounded-xl shadow p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-lg font-semibold">Sebaran Pemberi Rating per Provinsi</h2>
                    <p class="text-xs text-slate-500">Mengetahui jangkauan pelanggan.</p>
                </div>
            </div>
            <div class="max-w-2xl mx-auto">
                <canvas id="ratingProvinceChart" height="260"></canvas>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const switcher = document.getElementById('sellerSwitcher');
            if (switcher) {
                switcher.addEventListener('change', (event) => {
                    const targetUrl = event.target.value;
                    if (targetUrl) {
                        window.location.href = targetUrl;
                    }
                });
            }

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
                        }, {
                            type: 'line',
                            label: 'Jumlah Review',
                            data: @json($ratingCounts),
                            borderColor: '#10b981',
                            borderWidth: 2,
                            fill: false,
                            yAxisID: 'y1'
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
