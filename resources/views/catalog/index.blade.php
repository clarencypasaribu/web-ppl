@extends('layouts.app')

@section('title', 'Katalog Produk - Sellora')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
        use Illuminate\Support\Str;
    @endphp
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">
        <header class="text-center space-y-4">
            <h1 class="text-3xl md:text-4xl font-semibold text-slate-900">Katalog Produk</h1>
            <p class="text-slate-600 max-w-3xl mx-auto leading-relaxed">
                Jelajahi produk unggulan dari berbagai penjual Sellora. Setiap kartu menampilkan foto produk, kategori,
                ringkasan penjual, serta rating rata-rata dan komentar terbaru dari pengunjung.
            </p>
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
            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5 md:gap-6">
                @foreach ($products as $product)
                    @php
                        $imageUrl = null;
                        if ($product->image_path) {
                            $imageUrl = Str::startsWith($product->image_path, ['http://', 'https://'])
                                ? $product->image_path
                                : Storage::url($product->image_path);
                        }
                        $productUrl = route('catalog.show', $product);
                        $avgRating = round($product->reviews_avg_rating ?? 0, 1);
                        $highlightReview = $product->reviews->first();
                    @endphp
                    <a href="{{ $productUrl }}" class="group block h-full">
                        <article class="relative bg-white rounded-2xl shadow-sm border border-slate-200/70 overflow-hidden flex flex-col h-full transition transform group-hover:-translate-y-1 group-hover:shadow-lg">
                            <div class="h-44 bg-slate-100 overflow-hidden relative">
                                @if ($imageUrl)
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-sm text-slate-400">
                                        Tidak ada foto
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3 inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-indigo-600 shadow-sm border border-indigo-100">
                                    {{ $product->category->name ?? 'Kategori belum ditentukan' }}
                                </div>
                                <div class="absolute top-3 right-3 inline-flex items-center gap-1 rounded-full bg-slate-900/80 text-white px-3 py-1 text-xs font-semibold shadow-sm">
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 0 0 .95-.69l1.07-3.292Z" />
                                    </svg>
                                    <span>{{ number_format($avgRating, 1) }}</span>
                                </div>
                            </div>
                            <div class="p-5 flex-1 flex flex-col gap-4">
                                <div class="space-y-2">
                                    <h2 class="text-lg font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $product->name }}</h2>
                                    @if ($product->description)
                                        <p class="text-sm text-slate-600">{{ Str::limit($product->description, 120) }}</p>
                                    @endif
                                </div>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 font-medium text-slate-800">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-700 px-3 py-1">
                                        Stok {{ $product->stock }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-indigo-600 font-medium">
                                        {{ $product->seller->store_name ?? '-' }}
                                    </span>
                                    <span class="text-xs text-slate-400">{{ $product->reviews_count }} ulasan</span>
                                </div>
                                <div class="border border-slate-100 rounded-xl p-4 bg-slate-50 flex flex-col gap-3">
                                    <div class="flex items-center gap-2">
                                        <div class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 text-sm font-semibold text-amber-600 border border-amber-100">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 0 0 .95-.69l1.07-3.292Z" />
                                            </svg>
                                            {{ number_format($avgRating, 1) }}/5
                                        </div>
                                        <p class="text-sm text-slate-600">Rating</p>
                                    </div>
                                    @if ($highlightReview)
                                        <div class="bg-white border border-slate-100 rounded-lg p-3 text-sm shadow-[0_1px_0_rgba(15,23,42,0.03)]">
                                            <div class="flex items-center justify-between">
                                                <p class="font-semibold text-slate-700">{{ $highlightReview->reviewer_name }}</p>
                                                <span class="text-xs text-slate-400">{{ $highlightReview->province }}</span>
                                            </div>
                                            @if ($highlightReview->comment)
                                                <p class="text-sm text-slate-600 mt-1">{{ Str::limit($highlightReview->comment, 100) }}</p>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-sm text-slate-500">Belum ada komentar untuk produk ini.</p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
