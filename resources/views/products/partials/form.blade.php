@php
    use Illuminate\Support\Facades\Storage;

    $displayPrice = old('price');
    if ($displayPrice === null) {
        $priceNumeric = $product->price ?? null;
        $displayPrice = $priceNumeric !== null
            ? number_format((float) $priceNumeric, fmod((float) $priceNumeric, 1.0) === 0.0 ? 0 : 2, ',', '.')
            : '';
    }
@endphp

<div class="space-y-6">
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="seller_id" class="block text-sm font-semibold text-slate-700 mb-1">Pemilik Toko *</label>
            <select id="seller_id" name="seller_id" class="w-full border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-200" required>
                <option value="">Pilih penjual</option>
                @foreach ($sellers as $seller)
                    <option value="{{ $seller->id }}" @selected(old('seller_id', $product->seller_id ?? '') == $seller->id)>
                        {{ $seller->store_name }} ({{ $seller->province }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-1">Kategori *</label>
            <select id="category_id" name="category_id" class="w-full border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-200" required>
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="space-y-2">
        <label for="name" class="block text-sm font-semibold text-slate-700">Nama Produk *</label>
        <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-200" required>
    </div>

    <div class="space-y-2">
        <label for="description" class="block text-sm font-semibold text-slate-700">Deskripsi</label>
        <textarea id="description" name="description" rows="4" class="w-full border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-200">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="price" class="block text-sm font-semibold text-slate-700 mb-1">Harga (Rp) *</label>
            <input
                type="text"
                inputmode="decimal"
                id="price"
                name="price"
                value="{{ $displayPrice }}"
                class="w-full border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-200"
                placeholder="Contoh: 100.000 atau 100000"
                required
            >
            <p class="text-xs text-slate-500 mt-1">Gunakan titik sebagai pemisah ribuan bila diperlukan.</p>
        </div>
        <div>
            <label for="stock" class="block text-sm font-semibold text-slate-700 mb-1">Stok *</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock ?? '0') }}" class="w-full border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-200" min="0" required>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4 items-start">
        <div>
            <label for="product_image" class="block text-sm font-semibold text-slate-700 mb-1">Foto Produk</label>
            <input type="file" id="product_image" name="product_image" accept="image/*" class="w-full border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-200">
            <p class="text-xs text-slate-500 mt-1">Format JPG/PNG, maks 4 MB.</p>
        </div>
        @if (!empty($product?->image_path))
            <div>
                <p class="font-medium text-sm text-slate-600 mb-1">Foto saat ini:</p>
                <img src="{{ Storage::url($product->image_path) }}" alt="Foto produk" class="w-32 h-32 object-cover rounded-lg border border-slate-200">
            </div>
        @endif
    </div>

    <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2">
        <input type="checkbox" id="is_active" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-200" @checked(old('is_active', $product->is_active ?? true))>
        <label for="is_active" class="text-sm text-slate-700">Produk aktif dan tampil di katalog</label>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a.75.75 0 0 1 .75.75V9.25H17a.75.75 0 0 1 0 1.5h-6.25V17a.75.75 0 0 1-1.5 0v-6.25H3a.75.75 0 0 1 0-1.5h6.25V2.75A.75.75 0 0 1 10 2Z" /></svg>
            Simpan Produk
        </button>
    </div>
</div>
