@extends('layouts.app')

@section('title', 'Laporan Penjual - Sellora')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8 py-6">
        <header class="bg-white rounded-xl border border-purple-100 shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="space-y-2">
                    <p class="text-xs tracking-[0.3em] uppercase text-purple-500 font-semibold">Laporan Penjual</p>
                    <h1 class="text-3xl font-semibold text-purple-900">Laporan Penjualan</h1>
                    <p class="text-sm text-slate-500 max-w-3xl">Pantau stok tertinggi, performa rating, dan produk yang butuh restock dalam satu tempat.</p>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 gap-6">
            <section id="stock-report" class="bg-white border border-purple-100 shadow-sm rounded-xl overflow-hidden">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 p-5 bg-slate-50/60 border-b border-slate-100">
                    <div class="space-y-1">
                        <h2 class="text-lg font-semibold text-purple-900">Produk Berdasarkan Stok</h2>
                        <p class="text-sm text-slate-500">Urutan stok tertinggi hingga terendah.</p>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-500"
                        data-download-target="stock-report"
                        data-download-title="Laporan Stok Produk"
                    >
                        Download PDF
                    </button>
                </div>
                <div class="p-5 pt-0">
                    @include('reports.table', ['items' => $stockReport, 'containerClass' => 'overflow-hidden'])
                </div>
            </section>

            <section id="rating-report" class="bg-white border border-purple-100 shadow-sm rounded-xl overflow-hidden">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 p-5 bg-slate-50/60 border-b border-slate-100">
                    <div class="space-y-1">
                        <h2 class="text-lg font-semibold text-purple-900">Produk Berdasarkan Rating</h2>
                        <p class="text-sm text-slate-500">Urutan rating tertinggi.</p>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-500"
                        data-download-target="rating-report"
                        data-download-title="Laporan Rating Produk"
                    >
                        Download PDF
                    </button>
                </div>
                <div class="p-5 pt-0">
                    @include('reports.table', ['items' => $ratingReport, 'containerClass' => 'overflow-hidden'])
                </div>
            </section>

            <section id="critical-report" class="bg-white border border-purple-100 shadow-sm rounded-xl overflow-hidden">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 p-5 bg-slate-50/60 border-b border-slate-100">
                    <div class="space-y-1">
                        <h2 class="text-lg font-semibold text-purple-900">Produk Dengan Stok Kritis</h2>
                        <p class="text-sm text-slate-500">Produk yang perlu segera di-restock.</p>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-500"
                        data-download-target="critical-report"
                        data-download-title="Laporan Stok Kritis"
                    >
                        Download PDF
                    </button>
                </div>
                <div class="p-5 pt-0">
                    @include('reports.table', ['items' => $criticalStockReport, 'emptyText' => 'Semua stok aman.', 'containerClass' => 'overflow-hidden'])
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
            if (!target) {
                return;
            }

            const printWindow = window.open('', '_blank', 'width=1000,height=800');
            if (!printWindow) {
                return;
            }

            const styles = `
                <style>
                    * { box-sizing: border-box; }
                    body { font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif; margin: 0; padding: 24px; color: #0f172a; }
                    h2 { margin: 0 0 8px; color: #3b0764; }
                    p { margin: 0 0 12px; color: #475569; }
                    table { width: 100%; border-collapse: collapse; font-size: 12px; }
                    thead th { background: #f8fafc; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; padding: 10px; text-align: left; }
                    tbody td { padding: 10px; border-top: 1px solid #e2e8f0; }
                    tbody tr:nth-child(even) { background: #f8fafc; }
                    .card { border: 1px solid #e9d5ff; border-radius: 14px; overflow: hidden; }
                    .card__header { padding: 16px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
                    .card__body { padding: 16px; }
                </style>
            `;

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
                                ${target.querySelector('.p-5.pt-0')?.innerHTML ?? target.innerHTML}
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
