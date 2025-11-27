<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sellora - Marketplace Management Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    @php
        use Illuminate\Support\Facades\Storage;
        use Illuminate\Support\Str;
    @endphp
    <div class="relative overflow-hidden">
        <nav class="bg-white border-b border-slate-100">
            <div class="max-w-6xl mx-auto px-4 py-4 flex flex-wrap gap-4 items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/sellora-logo.png') }}" alt="Sellora" class="h-10 w-auto">
                    <span class="sr-only">Sellora</span>
                </a>
                <div class="flex-1 flex items-center gap-6 min-w-full md:min-w-[55%]">
                    <form action="{{ route('catalog.index') }}" method="GET" class="flex-1 relative">
                        <div class="flex items-center gap-2 bg-slate-100 rounded-full px-4 py-2 ring-1 ring-purple-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 3.473 9.745l3.64 3.64a.75.75 0 1 0 1.06-1.06l-3.64-3.64A5.5 5.5 0 0 0 9 3.5Zm-4 5.5a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd" />
                            </svg>
                            <input type="text" name="q" id="homeSearch" value="{{ request('q') }}" placeholder="Cari produk, toko, kategori, lokasi..." class="bg-transparent flex-1 text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none" autocomplete="off">
                        </div>
                        <div id="homeSearchHistory" class="hidden absolute left-0 right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-lg text-sm text-slate-700 max-h-48 overflow-y-auto z-10">
                            <!-- history injected by JS -->
                        </div>
                    </form>
                    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                        <a href="#catalog" class="hover:text-slate-900">Katalog</a>
                        <a href="#features" class="hover:text-slate-900">Fitur</a>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-slate-600">
                    <div class="relative">
                        <button id="headerDropdownBtn" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-purple-800">
                            Login
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.104l3.71-3.872a.75.75 0 1 1 1.08 1.04l-4.24 4.43a.75.75 0 0 1-1.08 0l-4.24-4.43a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="headerDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-lg shadow-lg py-2 text-sm">
                            <a href="{{ route('seller.login') }}" class="block px-4 py-2 text-slate-600 hover:bg-slate-50">Login Penjual</a>
                            <a href="{{ route('admin.login') }}" class="block px-4 py-2 text-slate-600 hover:bg-slate-50">Login Admin</a>
                        </div>
                    </div>
                    <a href="{{ route('sellers.register') }}" class="bg-purple-600 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-purple-700">Registrasi</a>
                </div>
            </div>
        </nav>

        <header class="bg-gradient-to-r from-purple-600 to-purple-500 text-white">
            <div class="max-w-6xl mx-auto px-4 py-20 text-center space-y-6">
                <p class="text-sm uppercase tracking-[0.4em] text-white/70 font-semibold">Platform Penjual Sellora</p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Kelola Toko Lebih Mudah dan Cepat bersama Sellora
                </h1>
                <p class="text-lg max-w-3xl mx-auto text-white/90">
                    Sellora membantu penjual mempublikasikan produk, menyiapkan katalog profesional, serta memantau komentar dan rating pelanggan dalam satu tempat.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#catalog" class="bg-white text-purple-600 font-semibold px-6 py-3 rounded-full shadow hover:bg-white/90">Lihat Katalog Publik</a>
                    <a href="{{ route('sellers.register') }}" class="border border-white/70 text-white font-semibold px-6 py-3 rounded-full hover:bg-white/10">Daftarkan Toko Anda</a>
                </div>
            </div>
        </header>

        <section id="features" class="max-w-6xl mx-auto px-4 py-14 space-y-10">
            <div class="text-center space-y-4">
                <h2 class="text-3xl font-semibold text-purple-900">Mengapa Sellora?</h2>
                <p class="text-slate-600 max-w-3xl mx-auto">
                    Kami menyiapkan alur khusus penjual: mulai dari registrasi toko, unggah produk, hingga alat analitik yang memudahkan Anda menjaga performa penjualan.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <p class="text-xs font-semibold uppercase tracking-widest text-purple-500 mb-2">Onboarding</p>
                    <h3 class="text-xl font-semibold mb-2">Registrasi Penjual Terpadu</h3>
                    <p class="text-sm text-slate-600">
                        Formulir lengkap yang memandu penjual hingga akun aktif: unggah dokumen, notifikasi email otomatis, dan pembuatan password sekali klik.
                    </p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <p class="text-xs font-semibold uppercase tracking-widest text-purple-500 mb-2">Inventori</p>
                    <h3 class="text-xl font-semibold mb-2">Katalog Produk Real-time</h3>
                    <p class="text-sm text-slate-600">
                        Penjual dapat menyalakan/menonaktifkan produk dan secara otomatis tampil di landing page beserta ulasan terbaru sebagai bukti kredibilitas toko.
                    </p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <p class="text-xs font-semibold uppercase tracking-widest text-purple-500 mb-2">Insight</p>
                    <h3 class="text-xl font-semibold mb-2">Dashboard Analitik</h3>
                    <p class="text-sm text-slate-600">
                        Grafik stok, performa rating, dan lokasi reviewer membantu penjual menyusun strategi stok serta promosi yang lebih tepat sasaran.
                    </p>
                </div>
            </div>
        </section>

        <section id="catalog" class="bg-purple-50 border-y border-purple-100">
            <div class="max-w-6xl mx-auto px-4 py-16 space-y-8">
                <div class="text-center space-y-3">
                    <h2 class="text-3xl font-semibold text-purple-900">Produk Unggulan Penjual Sellora</h2>
                    <p class="text-slate-600 max-w-3xl mx-auto">
                        Setiap produk yang Anda kelola di dashboard otomatis tampil ke publik, lengkap dengan ringkasan toko, rating rata-rata, dan komentar pembeli.
                    </p>
                </div>
                @if ($products->isEmpty())
                    <div class="bg-white border border-dashed border-purple-200 rounded-2xl p-10 text-center space-y-3">
                        <p class="text-xl font-semibold text-slate-700">Belum ada produk yang ditayangkan.</p>
                        <p class="text-slate-500 text-sm">Tambahkan produk aktif agar langsung muncul pada landing page dan katalog publik.</p>
                    </div>
                @else
                    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5 md:gap-6">
                        @foreach ($products as $product)
                            @php
                                $avgRating = round($product->reviews_avg_rating ?? 0, 1);
                                $highlightReview = $product->reviews->first();
                            @endphp
                            <article class="relative bg-white rounded-2xl shadow-sm border border-slate-200/70 overflow-hidden flex flex-col h-full transition transform hover:-translate-y-1 hover:shadow-lg">
                                <div class="h-44 bg-slate-100 overflow-hidden relative">
                                    @if ($product->image_path)
                                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-300 hover:scale-105">
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
                                        <h3 class="text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
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
                                            <p class="text-sm text-slate-600">Rating rata-rata</p>
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
                        @endforeach
                    </div>
                    <div class="text-center">
                        <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-purple-600 hover:text-purple-800">
                            Lihat semua produk
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 10a.75.75 0 0 1 .75-.75h7.19l-2.22-2.22a.75.75 0 1 1 1.06-1.06l3.5 3.5a.75.75 0 0 1 0 1.06l-3.5 3.5a.75.75 0 1 1-1.06-1.06l2.22-2.22H5.75A.75.75 0 0 1 5 10Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <section id="cta" class="max-w-5xl mx-auto px-4 py-16 text-center space-y-6">
            <h2 class="text-3xl font-semibold text-purple-900">Siap Berjualan di Sellora?</h2>
            <p class="text-slate-600">
                Aktifkan toko Anda, kelola katalog, dan pantau feedback pelanggan tanpa berpindah platform.
            </p>
            <div class="flex flex-wrap justify-center gap-3 text-sm">
                <a href="{{ route('sellers.register') }}" class="bg-purple-600 text-white px-5 py-3 rounded-lg hover:bg-purple-700 font-semibold">Daftarkan Toko</a>
                <a href="{{ route('seller.login') }}" class="px-5 py-3 rounded-lg border border-purple-200 text-purple-700 hover:border-purple-400 font-semibold">Masuk sebagai Penjual</a>
            </div>
        </section>

        <footer class="bg-white border-t border-slate-100">
            <div class="max-w-6xl mx-auto px-4 py-6 text-sm text-slate-500 flex flex-wrap justify-between gap-3">
                <span>© {{ date('Y') }} Sellora Platform</span>
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
        const homeSearch = document.getElementById('homeSearch');
        const homeSearchHistory = document.getElementById('homeSearchHistory');
        const HOME_SEARCH_HISTORY_KEY = 'sellora_search_history';

        dropdownBtn?.addEventListener('click', () => {
            dropdownMenu?.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!dropdownBtn?.contains(event.target) && !dropdownMenu?.contains(event.target)) {
                dropdownMenu?.classList.add('hidden');
            }
            if (!homeSearch?.contains(event.target) && !homeSearchHistory?.contains(event.target)) {
                homeSearchHistory?.classList.add('hidden');
            }
        });

        function getHomeHistory() {
            try {
                const raw = localStorage.getItem(HOME_SEARCH_HISTORY_KEY);
                return raw ? JSON.parse(raw) : [];
            } catch (e) {
                return [];
            }
        }

        function saveHomeHistory(term) {
            const clean = (term || '').trim();
            if (!clean) return;
            const list = getHomeHistory().filter((item) => item.toLowerCase() !== clean.toLowerCase());
            list.unshift(clean);
            localStorage.setItem(HOME_SEARCH_HISTORY_KEY, JSON.stringify(list.slice(0, 7)));
        }

        function renderHomeHistory() {
            if (!homeSearch || !homeSearchHistory) return;
            const history = getHomeHistory();
            if (!history.length) {
                homeSearchHistory.classList.add('hidden');
                homeSearchHistory.innerHTML = '';
                return;
            }

            const items = history.map((item) => `
                <div class="flex items-center justify-between px-4 py-2 hover:bg-slate-50">
                    <button type="button" class="flex-1 text-left" data-home-history-item="${item.replace(/"/g, '&quot;')}">${item}</button>
                    <button type="button" class="ml-3 text-slate-400 hover:text-rose-500" aria-label="Hapus riwayat" data-home-history-remove="${item.replace(/"/g, '&quot;')}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.22 4.22a.75.75 0 0 1 1.06 0L10 8.94l4.72-4.72a.75.75 0 1 1 1.06 1.06L11.06 10l4.72 4.72a.75.75 0 0 1-1.06 1.06L10 11.06l-4.72 4.72a.75.75 0 1 1-1.06-1.06L8.94 10 4.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `).join('');

            homeSearchHistory.innerHTML = `
                <div class="flex items-center justify-between px-4 py-2 text-xs font-semibold text-slate-500 border-b border-slate-100">
                    <span>Riwayat pencarian</span>
                    <button type="button" id="homeClearHistoryBtn" class="text-rose-600 hover:text-rose-700">Hapus semua</button>
                </div>
                ${items}
            `;
            homeSearchHistory.classList.remove('hidden');

            homeSearchHistory.querySelectorAll('[data-home-history-item]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const value = btn.getAttribute('data-home-history-item') || '';
                    homeSearch.value = value;
                    homeSearchHistory.classList.add('hidden');
                    homeSearch.closest('form')?.submit();
                });
            });

            homeSearchHistory.querySelectorAll('[data-home-history-remove]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const value = btn.getAttribute('data-home-history-remove') || '';
                    const updated = getHomeHistory().filter((item) => item.toLowerCase() !== value.toLowerCase());
                    localStorage.setItem(HOME_SEARCH_HISTORY_KEY, JSON.stringify(updated));
                    renderHomeHistory();
                });
            });

            const clearBtn = homeSearchHistory.querySelector('#homeClearHistoryBtn');
            clearBtn?.addEventListener('click', () => {
                localStorage.removeItem(HOME_SEARCH_HISTORY_KEY);
                renderHomeHistory();
            });
        }

        homeSearch?.addEventListener('focus', renderHomeHistory);
        homeSearch?.closest('form')?.addEventListener('submit', () => {
            saveHomeHistory(homeSearch.value || '');
        });
    </script>
</body>
</html>
