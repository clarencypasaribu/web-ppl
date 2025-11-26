<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MartPlace - Marketplace Management Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="relative overflow-hidden">
        <nav class="bg-white border-b border-slate-100">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2 font-semibold text-xl text-indigo-600">
                    <span class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">M</span>
                    MartPlace
                </div>
                <div class="flex items-center gap-3 text-sm font-medium">
                    <div class="relative">
                        <button id="headerDropdownBtn" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900">
                            Login
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.104l3.71-3.872a.75.75 0 111.08 1.04l-4.24 4.43a.75.75 0 01-1.08 0l-4.24-4.43a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="headerDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-lg shadow-lg py-2 text-sm">
                            <a href="{{ route('seller.login') }}" class="block px-4 py-2 text-slate-600 hover:bg-slate-50">Login Penjual</a>
                            <a href="{{ route('admin.login') }}" class="block px-4 py-2 text-slate-600 hover:bg-slate-50">Login Admin</a>
                        </div>
                    </div>
                    <a href="{{ route('sellers.register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Registrasi Penjual</a>
                </div>
            </div>
        </nav>

        <header class="bg-gradient-to-b from-white to-indigo-50">
            <div class="max-w-6xl mx-auto px-4 py-16 grid gap-10 items-center">
                <div class="space-y-6">
                    <p class="text-xs tracking-[0.3em] uppercase text-indigo-500 font-semibold">MartPlace Platform</p>
                    <h1 class="text-4xl font-bold leading-tight">
                        Kelola Penjual, Produk, dan Insight Marketplace dalam Satu Dashboard
                    </h1>
                    <p class="text-slate-600 text-lg">
                        MartPlace merangkum kebutuhan marketplace modern: alur registrasi penjual yang terarah, panel verifikasi untuk tim admin, manajemen katalog yang rapi, serta insight mendalam mengenai performa marketplace dan toko.
                    </p>
                    <div class="flex flex-wrap gap-3 text-sm">
                        <a href="{{ route('sellers.register') }}" class="bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700">Registrasi Penjual</a>
                        <a href="{{ route('seller.login') }}" class="px-5 py-3 rounded-lg border border-indigo-200 text-indigo-700 hover:border-indigo-400">Login Penjual</a>
                    </div>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="bg-white border border-slate-100 rounded-xl p-4">
                            <p class="text-3xl font-semibold text-indigo-600">100%</p>
                            <p class="text-xs text-slate-500 mt-1">Fitur alur lengkap</p>
                        </div>
                        <div class="bg-white border border-slate-100 rounded-xl p-4">
                            <p class="text-3xl font-semibold text-indigo-600">4+</p>
                            <p class="text-xs text-slate-500 mt-1">Grafik insight</p>
                        </div>
                        <div class="bg-white border border-slate-100 rounded-xl p-4">
                            <p class="text-3xl font-semibold text-indigo-600">2</p>
                            <p class="text-xs text-slate-500 mt-1">Jenis dashboard</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section id="features" class="max-w-6xl mx-auto px-4 py-16 space-y-10">
            <div class="text-center space-y-3">
                <h2 class="text-3xl font-semibold">Fitur Utama MartPlace</h2>
                <p class="text-slate-600 max-w-3xl mx-auto">
                    Kami membantu marketplace menumbuhkan penjual, menjaga kualitas administrasi, mengelola inventori, dan memahami perilaku pengunjung melalui insight visual yang mudah dipahami.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <p class="text-xs font-semibold uppercase tracking-widest text-indigo-500 mb-2">Onboarding</p>
                    <h3 class="text-xl font-semibold mb-2">Alur Penjual Terpadu</h3>
                    <p class="text-sm text-slate-600">
                        Form registrasi lengkap, unggah dokumen, dashboard verifikasi admin, notifikasi hasil, hingga pembuatan password penjual.
                    </p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500 mb-2">Inventori</p>
                    <h3 class="text-xl font-semibold mb-2">Kelola Kategori & Produk</h3>
                    <p class="text-sm text-slate-600">
                        Upload produk dengan foto, stok, harga; CRUD kategori; relasi ke penjual untuk memudahkan laporan stok dan sebaran.
                    </p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <p class="text-xs font-semibold uppercase tracking-widest text-amber-500 mb-2">Insight Visual</p>
                    <h3 class="text-xl font-semibold mb-2">Dashboard Grafis</h3>
                    <p class="text-sm text-slate-600">
                        Chart interaktif tentang sebaran produk, lokasi toko, status penjual, performa rating, serta daerah asal reviewer.
                    </p>
                </div>
            </div>
        </section>

        <section id="dashboards" class="bg-slate-900 text-white">
            <div class="max-w-5xl mx-auto px-4 py-16 space-y-10 text-center">
                <p class="text-xs uppercase tracking-[0.4em] text-emerald-300">Insight Penjual</p>
                <h2 class="text-3xl font-semibold">Dashboard Penjual</h2>
                <p class="text-slate-300 max-w-3xl mx-auto">
                    Setiap penjual memperoleh insight masing-masing: grafik stok, nilai rating per produk, dan sebaran pemberi rating per provinsi untuk memantau kinerja toko.
                </p>
                <ul class="space-y-2 text-slate-200 text-sm">
                    <li>• Bar chart stok per produk.</li>
                    <li>• Kombinasi bar+line rata-rata rating & jumlah review.</li>
                    <li>• Doughnut chart domisili pemberi rating.</li>
                    <li>• Dropdown untuk berpindah antar penjual.</li>
                </ul>
                <p class="text-sm text-slate-400">Contoh URL: <code class="bg-slate-800 text-emerald-300 px-2 py-1 rounded">/seller/1/dashboard</code></p>
            </div>
        </section>

        <section id="cta" class="max-w-5xl mx-auto px-4 py-16 text-center space-y-6">
            <h2 class="text-3xl font-semibold">Siap Memulai?</h2>
            <p class="text-slate-600">
                Daftarkan penjual baru atau kelola katalog produk Anda. Insight performa toko akan langsung muncul di dashboard penjual.
            </p>
            <div class="flex flex-wrap justify-center gap-3 text-sm">
                <a href="{{ route('sellers.register') }}" class="bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700">Registrasi Penjual Baru</a>
                <a href="{{ route('products.index') }}" class="px-5 py-3 rounded-lg border border-indigo-200 text-indigo-700 hover:border-indigo-400">Kelola Produk</a>
            </div>
        </section>

        <footer class="bg-white border-t border-slate-100">
            <div class="max-w-6xl mx-auto px-4 py-6 text-sm text-slate-500 flex flex-wrap justify-between gap-3">
                <span>© {{ date('Y') }} MartPlace Platform</span>
                <div class="flex gap-4">
                    <a href="{{ route('admin.login') }}" class="hover:text-slate-900">Login Admin Verifikasi</a>
                    <a href="{{ route('products.index') }}" class="hover:text-slate-900">Kategori & Produk</a>
                </div>
            </div>
    </footer>
    </div>
    <script>
        const dropdownBtn = document.getElementById('headerDropdownBtn');
        const dropdownMenu = document.getElementById('headerDropdownMenu');

        dropdownBtn?.addEventListener('click', () => {
            dropdownMenu?.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!dropdownBtn?.contains(event.target) && !dropdownMenu?.contains(event.target)) {
                dropdownMenu?.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
