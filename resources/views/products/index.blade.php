@extends('layouts.app')

@section('title', 'Manajemen Katalog Produk - Sellora')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
        use Illuminate\Support\Str;
        $activeFilters = array_filter($filters, fn ($value) => filled($value));
        $isSellerLoggedIn = session()->has('seller_auth_id');
    @endphp
    <div class="max-w-6xl mx-auto px-4 py-8 space-y-6">
        <header class="bg-white rounded-2xl border border-purple-100 shadow-sm p-6 space-y-3">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-[0.35em] text-purple-500 font-semibold">Manajemen Katalog</p>
                    <h1 class="text-3xl font-semibold text-purple-900">Produk & Kategori Toko Anda</h1>
                    <p class="text-sm text-slate-600">Pengaturan katalog, status produk, serta kategori dan lokasi toko.</p>
                </div>
                <div class="flex flex-wrap gap-3 text-sm">
                    @if ($isSellerLoggedIn)
                        <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-indigo-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2.5a1 1 0 0 1 1 1v5.5h5.5a1 1 0 0 1 0 2H11v5.5a1 1 0 0 1-2 0V11H3.5a1 1 0 0 1 0-2H9V3.5a1 1 0 0 1 1-1Z"/></svg>
                            Tambah Produk
                        </a>
                    @else
                        <a href="{{ route('seller.login') }}" class="inline-flex items-center bg-slate-200 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-300">Login untuk Mengelola</a>
                    @endif
                </div>
            </div>
        </header>

        @php
            $messages = [
                'product_created' => 'Produk baru berhasil disimpan.',
                'product_updated' => 'Produk berhasil diperbarui.',
                'product_deleted' => 'Produk berhasil dihapus.',
                'category_created' => 'Kategori baru berhasil ditambahkan.',
                'category_updated' => 'Kategori berhasil diperbarui.',
                'category_deleted' => 'Kategori berhasil dihapus.',
            ];
        @endphp

        @if (session('status') && isset($messages[session('status')]))
            <div class="rounded-md bg-emerald-50 border border-emerald-200 p-4 text-emerald-800">
                {{ $messages[session('status')] }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-md bg-rose-50 border border-rose-200 p-4 text-rose-700 text-sm">
                <p class="font-semibold mb-1">Periksa kembali formulir:</p>
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            @if ($isSellerLoggedIn)
                <section class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 space-y-4">
                    <header class="space-y-1">
                        <p class="text-xs uppercase tracking-[0.35em] text-indigo-500 font-semibold">Kategori</p>
                        <h2 class="text-xl font-semibold text-slate-900">Daftar Kategori Produk</h2>
                        <p class="text-xs text-slate-500">Untuk perhitungan sebaran produk pada dashboard.</p>
                    </header>

                    <div class="max-h-[320px] overflow-y-auto border border-slate-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-50 text-[11px] uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-3 py-2 text-left">Kategori</th>
                                    <th class="px-3 py-2 text-center">Produk</th>
                                    <th class="px-3 py-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr class="border-b border-slate-100 hover:bg-slate-50/60">
                                        <td class="px-3 py-2">
                                            <p class="font-medium text-slate-900">{{ $category->name }}</p>
                                            <p class="text-xs text-slate-500">{{ Str::limit($category->description, 50) ?: 'Belum ada deskripsi.' }}</p>
                                        </td>
                                        <td class="px-3 py-2 text-center text-slate-600">{{ $category->products_count }}</td>
                                        <td class="px-3 py-2 text-right text-xs space-x-2">
                                            <a href="{{ route('products.index', array_merge($activeFilters, ['edit_category' => $category->id])) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">Ubah</a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori {{ $category->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-3 py-4 text-center text-slate-500">Belum ada kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-slate-100 pt-4">
                        @if ($editingCategory)
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-slate-700">Ubah Kategori</h3>
                                <a href="{{ route('products.index', $activeFilters) }}" class="text-xs text-slate-500 hover:text-slate-800">Batal</a>
                            </div>
                            <form action="{{ route('categories.update', $editingCategory) }}" method="POST" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="category-name" class="text-xs font-medium text-slate-500">Nama *</label>
                                    <input type="text" id="category-name" name="name" value="{{ old('name', $editingCategory->name) }}" class="w-full border-slate-300 rounded-lg" required>
                                </div>
                                <div>
                                    <label for="category-description" class="text-xs font-medium text-slate-500">Deskripsi</label>
                                    <textarea id="category-description" name="description" rows="2" class="w-full border-slate-300 rounded-lg">{{ old('description', $editingCategory->description) }}</textarea>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 text-white text-sm font-semibold py-2 rounded-lg hover:bg-indigo-700 shadow-sm">Perbarui</button>
                            </form>
                        @else
                            <h3 class="text-sm font-semibold text-slate-700 mb-2">Tambah Kategori Baru</h3>
                            <form action="{{ route('categories.store') }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label for="category-name" class="text-xs font-medium text-slate-500">Nama *</label>
                                    <input type="text" id="category-name" name="name" value="{{ old('name') }}" class="w-full border-slate-300 rounded-lg" required>
                                </div>
                                <div>
                                    <label for="category-description" class="text-xs font-medium text-slate-500">Deskripsi</label>
                                    <textarea id="category-description" name="description" rows="2" class="w-full border-slate-300 rounded-lg">{{ old('description') }}</textarea>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 text-white text-sm font-semibold py-2 rounded-lg hover:bg-indigo-700 shadow-sm">Simpan</button>
                            </form>
                        @endif
                    </div>
                </section>
            @else
                <section class="bg-white rounded-2xl shadow border border-slate-100 p-6 space-y-4">
                    <h2 class="text-xl font-semibold">Hanya Penjual Terverifikasi</h2>
                    <p class="text-sm text-slate-600">Masuk ke akun penjual untuk menambah kategori dan mengelola katalog Anda.</p>
                    <a href="{{ route('seller.login') }}" class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold">Login Penjual</a>
                </section>
            @endif

            <section class="lg:col-span-2 space-y-4">
                <form action="{{ route('products.index') }}" method="GET" class="bg-white border border-slate-200 rounded-2xl p-5 shadow flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[180px]">
                        <label class="text-xs font-semibold text-slate-500">Nama Produk</label>
                        <input type="text" name="q" value="{{ $filters['q'] }}" class="w-full border-slate-300 rounded-lg" placeholder="Nama atau deskripsi produk">
                    </div>
                    <div class="flex-1 min-w-[180px]">
                        <label class="text-xs font-semibold text-slate-500">Nama Toko</label>
                        <input type="text" name="seller" value="{{ $filters['seller'] }}" class="w-full border-slate-300 rounded-lg" placeholder="Contoh: Alfamidi">
                    </div>
                    <div class="flex-1 min-w-[180px]">
                        <label class="text-xs font-semibold text-slate-500">Kategori</label>
                        <select name="category_id" class="w-full border-slate-300 rounded-lg">
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($filters['category_id'] == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-[180px]">
                        <label class="text-xs font-semibold text-slate-500">Kota/Kabupaten</label>
                        <input type="text" name="city" value="{{ $filters['city'] }}" class="w-full border-slate-300 rounded-lg" placeholder="Cari kota toko">
                    </div>
                    <div class="flex-1 min-w-[180px]">
                        <label class="text-xs font-semibold text-slate-500">Provinsi</label>
                        <input type="text" name="province" value="{{ $filters['province'] }}" class="w-full border-slate-300 rounded-lg" placeholder="Cari provinsi">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Terapkan Filter</button>
                        @if (array_filter($filters))
                            <a href="{{ route('products.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Reset</a>
                        @endif
                    </div>
                </form>

                @if (array_filter($filters))
                    <div class="text-xs text-slate-500">
                        <p>Filter aktif:
                            @foreach ($filters as $label => $value)
                                @if ($value)
                                    <span class="inline-flex items-center bg-slate-100 px-2 py-1 rounded-full text-[11px] font-medium text-slate-600 mr-1">
                                        {{ strtoupper(str_replace('_', ' ', $label)) }}: {{ $value }}
                                    </span>
                                @endif
                            @endforeach
                        </p>
                    </div>
                @endif

                <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-100">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3 text-left">Produk</th>
                                <th class="px-4 py-3 text-left">Kategori</th>
                                <th class="px-4 py-3 text-left">Pemilik</th>
                                <th class="px-4 py-3 text-left">Detail Produk</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($products as $product)
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-4 py-3 align-top">
                                        <div class="flex items-start gap-3">
                                            @if ($product->image_path)
                                                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg border border-slate-200">
                                            @else
                                                <div class="w-12 h-12 rounded-lg bg-slate-100 border border-dashed border-slate-300 flex items-center justify-center text-xs text-slate-400">
                                                    Tidak ada
                                                </div>
                                            @endif
                                            <div class="min-w-[140px]">
                                                <p class="font-semibold text-slate-900 leading-tight">{{ $product->name }}</p>
                                                <p class="text-xs text-slate-500 leading-snug">{{ Str::limit($product->description, 40) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ $product->category->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $product->seller->store_name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <button
                                            type="button"
                                            class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold"
                                            data-product-detail="product-{{ $product->id }}"
                                        >
                                            Lihat Detail
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.104l3.71-3.872a.75.75 0 1 1 1.08 1.04l-4.24 4.43a.75.75 0 0 1-1.08 0l-4.24-4.43a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($isSellerLoggedIn)
                                            <div class="flex justify-end gap-3 text-sm">
                                                <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">Ubah</a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $product->name }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Hapus</button>
                                                </form>
                                            </div>
                                        @else
                                            <p class="text-xs text-slate-400 text-right">Login untuk mengelola</p>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-10 text-center text-slate-500">Belum ada produk terdaftar. Gunakan tombol "Tambah Produk".</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    @if ($isSellerLoggedIn)
        @foreach ($products as $product)
            <div id="product-{{ $product->id }}" class="hidden">
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        @if ($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-14 h-14 object-cover rounded-lg border border-slate-200">
                        @else
                            <div class="w-14 h-14 rounded-lg bg-slate-100 border border-dashed border-slate-300 flex items-center justify-center text-xs text-slate-400">
                                Tidak ada
                            </div>
                        @endif
                        <div class="space-y-1">
                            <p class="text-xs uppercase tracking-[0.35em] text-indigo-500 font-semibold">Detail Produk</p>
                            <p class="text-lg font-semibold text-slate-900">{{ $product->name }}</p>
                            <p class="text-sm text-slate-500">{{ Str::limit($product->description, 120) }}</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-3 text-sm">
                        <div class="space-y-1">
                            <p class="font-semibold text-slate-800">Lokasi Toko</p>
                            <p class="text-slate-600">{{ $product->seller->city ?? '-' }}, {{ $product->seller->province ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold text-slate-800">Harga</p>
                            <p class="text-slate-900 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold text-slate-800">Stok</p>
                            <p class="text-slate-700">{{ $product->stock }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold text-slate-800">Status</p>
                            @if ($product->is_active)
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Aktif</span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@push('scripts')
    <script>
        const productDetailButtons = document.querySelectorAll('[data-product-detail]');

        if (productDetailButtons.length) {
            const productModal = document.createElement('div');
            productModal.className = 'fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 px-4 py-6';
            const productModalCard = document.createElement('div');
            productModalCard.className = 'w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden';
            productModal.appendChild(productModalCard);
            document.body.appendChild(productModal);

            const closeProductModal = () => {
                productModal.classList.add('hidden');
                productModalCard.innerHTML = '';
            };

            productModal.addEventListener('click', (event) => {
                if (event.target === productModal) {
                    closeProductModal();
                }
            });

            productDetailButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-product-detail');
                    const template = document.getElementById(targetId);
                    if (!template) return;

                    productModalCard.innerHTML = `
                        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                            <div class="space-y-1">
                                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Detail Produk</p>
                                <h3 class="text-lg font-semibold text-slate-900">Informasi Lengkap</h3>
                            </div>
                            <button class="text-slate-500 hover:text-slate-700" aria-label="Tutup detail" id="productModalCloseBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.22 4.22a.75.75 0 0 1 1.06 0L10 8.94l4.72-4.72a.75.75 0 1 1 1.06 1.06L11.06 10l4.72 4.72a.75.75 0 0 1-1.06 1.06L10 11.06l-4.72 4.72a.75.75 0 1 1-1.06-1.06L8.94 10 4.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div class="p-5 max-h-[75vh] overflow-y-auto space-y-4">
                            ${template.innerHTML}
                        </div>
                    `;

                    productModal.classList.remove('hidden');
                    productModalCard.querySelector('#productModalCloseBtn')?.addEventListener('click', closeProductModal);
                });
            });
        }
    </script>
@endpush
