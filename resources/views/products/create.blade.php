@extends('layouts.app')

@section('title', 'Tambah Produk Penjual - Sellora')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10 space-y-6">
        <header class="bg-white rounded-2xl border border-purple-100 shadow-sm p-6 space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-[0.35em] text-purple-500 font-semibold">Tambah Produk</p>
                    <h1 class="text-3xl font-semibold text-purple-900">Upload Produk Penjual</h1>
                    <p class="text-sm text-slate-600">Lengkapi detail produk, foto, kategori, dan status tampil publik.</p>
                </div>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M11.78 4.22a.75.75 0 0 1 0 1.06L8.06 9l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"/></svg>
                    Lihat daftar produk
                </a>
            </div>
        </header>

        @if ($errors->any())
            <div class="rounded-md bg-rose-50 border border-rose-200 p-4 text-rose-800">
                <p class="font-medium mb-2">Periksa kembali formulir:</p>
                <ul class="list-disc ml-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm border border-slate-100 rounded-2xl p-6">
            @csrf
            @include('products.partials.form', ['product' => null, 'categories' => $categories, 'sellers' => $sellers])
        </form>
    </div>
@endsection
