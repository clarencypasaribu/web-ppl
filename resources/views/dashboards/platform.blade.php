@extends('layouts.app')

@section('title', 'Dashboard Platform - Sellora')

@section('content')
    @php
        $productCategoryLabels = $productsByCategory->pluck('name');
        $productCategoryValues = $productsByCategory->pluck('products_count');
        $provinceLabels = $storesByProvince->map(fn($row) => $row->province ?: 'Belum diisi');
        $provinceValues = $storesByProvince->pluck('total');
        $sellerStatusLabels = ['Aktif', 'Tidak Aktif'];
        $sellerStatusValues = [$activeSellers, $inactiveSellers];
    @endphp

    <div class="max-w-6xl mx-auto px-4 py-10 space-y-6">
        <header class="flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-semibold">Dashboard Platform (SRS-Sellora-07)</h1>
                <p class="text-sm text-slate-600">Visualisasi sebaran produk, toko, status penjual, serta partisipasi pengunjung.</p>
            </div>
            <div class="text-sm space-y-1">
                <a href="{{ route('products.index') }}" class="block text-indigo-600 hover:text-indigo-800">Kelola Kategori & Produk →</a>
                <a href="{{ route('admin.login') }}" class="block text-indigo-600 hover:text-indigo-800">Login Admin Verifikasi →</a>
            </div>
        </header>

        <section class="grid md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-sm text-slate-500">Penjual Aktif</p>
                <p class="text-3xl font-semibold mt-2">{{ $activeSellers }}</p>
                <p class="text-xs text-emerald-600 mt-1">Status: approved</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-sm text-slate-500">Penjual Tidak Aktif</p>
                <p class="text-3xl font-semibold mt-2">{{ $inactiveSellers }}</p>
                <p class="text-xs text-slate-500 mt-1">Status pending/ditolak</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-sm text-slate-500">Pengunjung Memberi Rating & Komentar</p>
                <p class="text-3xl font-semibold mt-2">{{ $reviewsCount }}</p>
                <p class="text-xs text-slate-500 mt-1">Total entri di tabel product_reviews</p>
            </div>
        </section>

        <section class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-5">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-semibold">Sebaran Produk per Kategori</h2>
                        <p class="text-xs text-slate-500">Mengukur pemerataan katalog.</p>
                    </div>
                </div>
                <canvas id="productCategoryChart" height="240"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-semibold">Sebaran Toko per Provinsi</h2>
                        <p class="text-xs text-slate-500">Sesuai alamat registrasi seller.</p>
                    </div>
                </div>
                <canvas id="storeProvinceChart" height="240"></canvas>
            </div>
        </section>

        <section class="bg-white rounded-xl shadow p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-lg font-semibold">Status Penjual</h2>
                    <p class="text-xs text-slate-500">Monitoring kondisi approval.</p>
                </div>
            </div>
            <div class="max-w-sm mx-auto">
                <canvas id="sellerStatusChart" height="260"></canvas>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const productCtx = document.getElementById('productCategoryChart');
            if (productCtx) {
                new Chart(productCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($productCategoryLabels),
                        datasets: [
                            {
                                label: 'Jumlah Produk',
                                data: @json($productCategoryValues),
                                backgroundColor: '#4f46e5'
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            const storeCtx = document.getElementById('storeProvinceChart');
            if (storeCtx) {
                new Chart(storeCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($provinceLabels),
                        datasets: [
                            {
                                label: 'Jumlah Toko',
                                data: @json($provinceValues),
                                backgroundColor: '#0ea5e9'
                            }
                        ]
                    },
                    options: {
                        indexAxis: 'y',
                        scales: {
                            x: { beginAtZero: true }
                        }
                    }
                });
            }

            const sellerCtx = document.getElementById('sellerStatusChart');
            if (sellerCtx) {
                new Chart(sellerCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($sellerStatusLabels),
                        datasets: [
                            {
                                data: @json($sellerStatusValues),
                                backgroundColor: ['#22c55e', '#cbd5f5']
                            }
                        ]
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
