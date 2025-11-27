@php
    $emptyText = $emptyText ?? 'Belum ada data.';
    $containerClass = $containerClass ?? 'bg-white rounded-2xl border border-purple-100 shadow-sm overflow-hidden';
@endphp

<div class="{{ $containerClass }}">
    <table class="min-w-full divide-y divide-slate-100 text-sm">
        <thead class="bg-slate-50 uppercase text-xs tracking-wide text-slate-500">
            <tr>
                <th class="px-4 py-3 text-left">Produk</th>
                <th class="px-4 py-3 text-left">Kategori</th>
                <th class="px-4 py-3 text-left">Toko</th>
                <th class="px-4 py-3 text-center">Stok</th>
                <th class="px-4 py-3 text-center">Rating</th>
                <th class="px-4 py-3 text-right">Harga</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($items as $product)
                <tr>
                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $product->name }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $product->seller->store_name ?? '-' }}</td>
                    <td class="px-4 py-3 text-center text-slate-700">{{ $product->stock }}</td>
                    <td class="px-4 py-3 text-center text-amber-500 font-semibold">
                        {{ number_format($product->reviews_avg_rating ?? 0, 1) }}/5
                    </td>
                    <td class="px-4 py-3 text-right font-semibold text-slate-800">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500">{{ $emptyText }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
