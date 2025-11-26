@extends('layouts.app')

@section('title', 'Laporan Penjual - Sellora')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8 py-6">
        <header class="bg-white rounded-3xl border border-purple-100 shadow-sm p-6 space-y-4">
            <div class="flex flex-wrap justify-between gap-4 items-center">
                <div>
                    <p class="text-xs tracking-[0.4em] uppercase text-purple-500 font-semibold">Laporan Penjual</p>
                    <h1 class="text-3xl font-semibold text-purple-900">Rangkuman Stok & Rating Produk</h1>
                    <p class="text-sm text-slate-600">
                        Mendukung SRS-MartPlace-12 sampai 14 dengan menampilkan daftar stok berdasarkan urutan
                        berbeda serta stok kritis &lt; 2.
                    </p>
                </div>
                <form action="{{ route('reports.seller') }}" method="GET" class="flex items-center gap-2 text-sm">
                    <label for="seller_id" class="text-slate-600">Pilih toko:</label>
                    <select id="seller_id" name="seller_id" class="border-purple-200 rounded-lg focus:border-purple-400 focus:ring-purple-400 text-sm py-2">
                        <option value="">Semua Toko</option>
                        @foreach ($sellerOptions as $option)
                            <option value="{{ $option->id }}" @selected($selectedSellerId === $option->id)>{{ $option->store_name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700">Terapkan</button>
                </form>
            </div>
        </header>

        <section class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-purple-900">SRS-MartPlace-12: Produk Berdasarkan Stok</h2>
                <p class="text-sm text-slate-500">Urutan stok tertinggi hingga terendah.</p>
            </div>
            @include('reports.table', ['items' => $stockReport])
        </section>

        <section class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-purple-900">SRS-MartPlace-13: Produk Berdasarkan Rating</h2>
                <p class="text-sm text-slate-500">Urutan rating tertinggi.</p>
            </div>
            @include('reports.table', ['items' => $ratingReport])
        </section>

        <section class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-purple-900">SRS-MartPlace-14: Stok Kritis (&lt; 2)</h2>
                <p class="text-sm text-slate-500">Produk yang perlu segera di-restock.</p>
            </div>
            @include('reports.table', ['items' => $criticalStockReport, 'emptyText' => 'Semua stok aman.'])
        </section>
    </div>
@endsection
