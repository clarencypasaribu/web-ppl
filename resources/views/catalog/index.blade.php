@extends('layouts.app')

@section('title', 'Katalog Produk - Sellora')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
        use Illuminate\Support\Str;
    @endphp
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">
        <header class="text-center space-y-4">
            <p class="text-xs tracking-[0.4em] uppercase text-indigo-500 font-semibold">SRS-Sellora-04</p>
            <h1 class="text-4xl font-semibold">Katalog Produk Publik</h1>
            <p class="text-slate-600 max-w-3xl mx-auto">
                Jelajahi produk unggulan dari berbagai penjual Sellora. Setiap kartu menampilkan foto produk, kategori,
                ringkasan penjual, serta rating rata-rata dan komentar terbaru dari pengunjung.
            </p>
            <div class="flex flex-wrap gap-3 justify-center text-sm">
                <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800">← Kembali ke Landing Page</a>
                <a href="{{ route('sellers.register') }}" class="text-sm text-emerald-600 hover:text-emerald-800">Daftarkan toko Anda</a>
            </div>
        </header>

        @if ($products->isEmpty())
            <div class="bg-white rounded-2xl shadow p-10 text-center space-y-3">
                <p class="text-xl font-semibold">Belum ada produk tersedia</p>
                <p class="text-slate-500">Segera tambahkan produk melalui panel manajemen agar tampil di katalog publik.</p>
                <a href="{{ route('products.create') }}" class="inline-flex items-center bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                    Tambah Produk
                </a>
            </div>
        @else
            <div class="grid md:grid-cols-2 gap-6">
                @foreach ($products as $product)
                    <article class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                        <div class="h-56 bg-slate-100">
                            @if ($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-sm text-slate-400">
                                    Tidak ada foto
                                </div>
                            @endif
                        </div>
                        <div class="p-6 flex-1 flex flex-col space-y-4">
                            <div class="space-y-1">
                                <p class="text-xs uppercase tracking-widest text-indigo-500">{{ $product->category->name ?? 'Kategori belum ditentukan' }}</p>
                                <h2 class="text-2xl font-semibold">{{ $product->name }}</h2>
                                @if ($product->description)
                                    <p class="text-sm text-slate-600">{{ Str::limit($product->description, 160) }}</p>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                                <span class="font-medium text-slate-700">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span>Stock: {{ $product->stock }}</span>
                                <span>Penjual: {{ $product->seller->store_name ?? '-' }}</span>
                            </div>
                            <div class="border border-slate-100 rounded-xl p-4 bg-slate-50">
                                <div class="flex flex-wrap items-center gap-3">
                                    @php
                                        $avgRating = round($product->reviews_avg_rating ?? 0, 1);
                                    @endphp
                                    <div class="flex items-center gap-1 text-amber-500 font-semibold">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 0 0 .95-.69l1.07-3.292Z" />
                                        </svg>
                                        <span>{{ number_format($avgRating, 1) }}</span>
                                    </div>
                                    <span class="text-xs text-slate-500">{{ $product->reviews_count }} ulasan</span>
                                </div>
                                <div class="mt-3 space-y-3">
                                    @forelse ($product->reviews as $review)
                                        <div class="bg-white border border-slate-100 rounded-lg p-3 text-sm">
                                            <div class="flex items-center justify-between">
                                                <p class="font-semibold text-slate-700">{{ $review->reviewer_name }}</p>
                                                <span class="text-xs text-slate-400">{{ $review->province }}</span>
                                            </div>
                                            <p class="text-xs text-amber-500 font-semibold mt-1">Rating: {{ $review->rating }}/5</p>
                                            @if ($review->comment)
                                                <p class="text-sm text-slate-600 mt-1">{{ $review->comment }}</p>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-sm text-slate-500">Belum ada komentar untuk produk ini.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
@endsection
