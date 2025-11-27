@extends('layouts.app')

@section('title', 'Laporan Platform - Sellora')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">
        <header class="bg-white border border-purple-100 rounded-2xl shadow-sm p-6 flex flex-col gap-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Laporan Platform</p>
                <h1 class="text-3xl font-semibold text-purple-900">Rangkuman Penjual & Produk</h1></p>
            </div>
        </header>

        <div class="space-y-6">
            <section id="report-active" class="bg-white border border-slate-100 rounded-xl shadow-sm overflow-hidden">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-5 py-4 bg-slate-50/70 border-b border-slate-100">
                    <div>
                        <h2 class="text-lg font-semibold text-purple-900">Laporan Akun Penjual Aktif & Tidak Aktif</h2>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-500"
                        data-download-target="report-active"
                        data-download-title="Akun Penjual Aktif & Tidak Aktif"
                    >
                        Download PDF
                    </button>
                </div>
                <div class="p-5 pt-0 space-y-5">
                    <div class="border border-slate-100 rounded-lg overflow-hidden">
                        <div class="px-4 py-2 bg-emerald-50 text-emerald-700 text-sm font-semibold border-b border-slate-100">Penjual Aktif</div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                    <tr>
                                        <th class="px-3 py-2 text-left">Toko</th>
                                        <th class="px-3 py-2 text-left">PIC</th>
                                        <th class="px-3 py-2 text-left">Email</th>
                                        <th class="px-3 py-2 text-left">Provinsi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($activeSellers as $seller)
                                        <tr>
                                            <td class="px-3 py-2 font-semibold text-slate-800">{{ $seller->store_name }}</td>
                                            <td class="px-3 py-2 text-slate-700">{{ $seller->pic_name }}</td>
                                            <td class="px-3 py-2 text-slate-600">{{ $seller->pic_email }}</td>
                                            <td class="px-3 py-2 text-slate-600">{{ $seller->province ?: '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-3 py-4 text-center text-slate-500">Belum ada penjual aktif.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="border border-slate-100 rounded-lg overflow-hidden">
                        <div class="px-4 py-2 bg-rose-50 text-rose-700 text-sm font-semibold border-b border-slate-100">Penjual Tidak Aktif</div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                    <tr>
                                        <th class="px-3 py-2 text-left">Toko</th>
                                        <th class="px-3 py-2 text-left">Status</th>
                                        <th class="px-3 py-2 text-left">PIC</th>
                                        <th class="px-3 py-2 text-left">Provinsi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($inactiveSellers as $seller)
                                        <tr>
                                            <td class="px-3 py-2 font-semibold text-slate-800">{{ $seller->store_name }}</td>
                                            <td class="px-3 py-2 text-slate-700 capitalize">{{ $seller->status }}</td>
                                            <td class="px-3 py-2 text-slate-600">{{ $seller->pic_name ?? '-' }}</td>
                                            <td class="px-3 py-2 text-slate-600">{{ $seller->province ?: '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-3 py-4 text-center text-slate-500">Semua penjual sedang aktif.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section id="report-province" class="bg-white border border-slate-100 rounded-xl shadow-sm overflow-hidden">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-5 py-4 bg-slate-50/70 border-b border-slate-100">
                    <div>
                        <h2 class="text-lg font-semibold text-purple-900">Laporan Penjual per Provinsi</h2>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-500"
                        data-download-target="report-province"
                        data-download-title="Laporan Penjual per Provinsi"
                    >
                        Download PDF
                    </button>
                </div>
                <div class="p-5 pt-0">
                    <div class="overflow-x-auto border border-slate-100 rounded-lg">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-3 py-2 text-left">Provinsi</th>
                                    <th class="px-3 py-2 text-right">Jumlah Toko</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($sellersByProvince as $row)
                                    <tr>
                                        <td class="px-3 py-2 font-semibold text-slate-800">{{ $row->province ?: 'Tidak diketahui' }}</td>
                                        <td class="px-3 py-2 text-right text-slate-700">{{ $row->total }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="px-3 py-4 text-center text-slate-500">Belum ada data penjual.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="report-products" class="bg-white border border-slate-100 rounded-xl shadow-sm overflow-hidden">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-5 py-4 bg-slate-50/70 border-b border-slate-100">
                    <div>
                        <h2 class="text-lg font-semibold text-purple-900">Laporan Produk & Rating</h2>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-500"
                        data-download-target="report-products"
                        data-download-title="Laporan Produk & Rating"
                    >
                        Download PDF
                    </button>
                </div>
                <div class="p-5 pt-0">
                    <div class="overflow-x-auto border border-slate-100 rounded-lg">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-3 py-2 text-left">Produk</th>
                                    <th class="px-3 py-2 text-left">Toko</th>
                                    <th class="px-3 py-2 text-left">Kategori</th>
                                    <th class="px-3 py-2 text-left">Provinsi</th>
                                    <th class="px-3 py-2 text-right">Harga</th>
                                    <th class="px-3 py-2 text-center">Rating</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($productsByRating as $product)
                                    <tr>
                                        <td class="px-3 py-2 font-semibold text-slate-800">{{ $product->name }}</td>
                                        <td class="px-3 py-2 text-slate-700">{{ $product->seller->store_name ?? '-' }}</td>
                                        <td class="px-3 py-2 text-slate-600">{{ $product->category->name ?? '-' }}</td>
                                        <td class="px-3 py-2 text-slate-600">{{ $product->seller->province ?? '-' }}</td>
                                        <td class="px-3 py-2 text-right text-slate-800">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="px-3 py-2 text-center text-amber-600 font-semibold">{{ number_format($product->reviews_avg_rating ?? 0, 1) }}/5</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-3 py-4 text-center text-slate-500">Belum ada produk.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const downloadButtons = document.querySelectorAll('[data-download-target]');

        function printSection(sectionId, title) {
            const target = document.getElementById(sectionId);
            if (!target) return;

            const printWindow = window.open('', '_blank', 'width=1200,height=900');
            if (!printWindow) return;

            const styles = `
                <style>
                    * { box-sizing: border-box; }
                    body { font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif; margin: 0; padding: 24px; color: #0f172a; }
                    h2 { margin: 0 0 12px; color: #3b0764; }
                    p { margin: 0 0 12px; color: #475569; }
                    table { width: 100%; border-collapse: collapse; font-size: 12px; }
                    thead th { background: #f8fafc; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; padding: 10px; text-align: left; }
                    tbody td { padding: 10px; border-top: 1px solid #e2e8f0; }
                    tbody tr:nth-child(even) { background: #f8fafc; }
                    .card { border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; }
                    .card__header { padding: 16px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
                    .card__body { padding: 16px; }
                </style>
            `;

            const content = target.querySelector('.p-5.pt-0')?.innerHTML || target.innerHTML;

            printWindow.document.write(`
                <html>
                    <head>
                        <title>${title}</title>
                        ${styles}
                    </head>
                    <body>
                        <div class="card">
                            <div class="card__header">
                                <h2>${title}</h2>
                            </div>
                            <div class="card__body">
                                ${content}
                            </div>
                        </div>
                        <script>window.print();<\/script>
                    </body>
                </html>
            `);
            printWindow.document.close();
        }

        downloadButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const sectionId = button.getAttribute('data-download-target');
                const title = button.getAttribute('data-download-title') || 'Laporan';
                printSection(sectionId, title);
            });
        });
    </script>
@endpush
