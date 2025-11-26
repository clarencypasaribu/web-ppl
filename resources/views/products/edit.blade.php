@extends('layouts.app')

@section('title', 'Ubah Produk Penjual - Sellora')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10 space-y-6">
        <header>
            <h1 class="text-3xl font-semibold mb-2">Ubah Produk Penjual</h1>
            <p class="text-sm text-slate-600">Perbarui informasi produk dan stok.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 mt-2">← Kembali ke daftar produk</a>
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

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-xl p-6">
            @csrf
            @method('PUT')
            @include('products.partials.form', ['product' => $product, 'categories' => $categories, 'sellers' => $sellers])
        </form>
    </div>
@endsection
