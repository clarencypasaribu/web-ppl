<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sellora Platform')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('head')
</head>
<body class="bg-slate-100 text-slate-900">
    @php
        use App\Models\Seller;

        $isSeller = session()->has('seller_auth_id') && ! session('is_admin');
        $sellerGreetingName = null;
        if ($isSeller) {
            $sellerGreetingName = Seller::find(session('seller_auth_id'))?->store_name;
        }
    @endphp
        <div class="min-h-screen flex flex-col">
            <header class="sticky top-0 z-10 bg-white border-b border-slate-100">
                <div class="max-w-6xl mx-auto px-4 py-3 flex flex-wrap gap-4 items-center justify-between">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/sellora-logo.png') }}" alt="Sellora" class="h-8 w-auto">
                    </a>
                    @if(session('is_admin') || $isSeller)
                        <nav class="flex flex-wrap gap-4 text-sm font-medium text-slate-600 items-center">
                            <a href="{{ route('catalog.index') }}" class="hover:text-purple-800">Katalog Produk</a>
                            @if(session('is_admin'))
                                <a href="{{ route('dashboard.platform') }}" class="hover:text-purple-800">Dashboard Platform</a>
                                <a href="{{ route('sellers.verifications') }}" class="hover:text-purple-800">Verifikasi</a>
                                <a href="{{ route('reports.platform') }}" class="hover:text-purple-800">Laporan</a>
                            @else
                                <a href="{{ route('seller.home') }}" class="hover:text-purple-800">Dashboard</a>
                                <a href="{{ route('products.create') }}" class="hover:text-purple-800">Upload Produk</a>
                                <a href="{{ route('reports.seller') }}" class="hover:text-purple-800">Laporan</a>
                            @endif
                            @if($sellerGreetingName)
                                <span class="text-purple-700 font-semibold">Halo, Toko {{ $sellerGreetingName }}!</span>
                            @endif
                            <div class="relative">
                                <button id="profileToggle" class="inline-flex items-center gap-2 text-purple-700 hover:text-purple-900 p-1 rounded-full focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-200" aria-label="Menu profil">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 2a5 5 0 0 0-3.536 8.536A7 7 0 0 0 3 17a1 1 0 1 0 2 0 5 5 0 0 1 10 0 1 1 0 1 0 2 0 7 7 0 0 0-3.464-6.464A5 5 0 0 0 10 2Zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6Z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.104l3.71-3.872a.75.75 0 1 1 1.08 1.04l-4.24 4.43a.75.75 0 0 1-1.08 0l-4.24-4.43a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-lg shadow-lg py-2 text-sm">
                                    @if(session('is_admin'))
                                        <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-slate-600 hover:bg-slate-50">Detail Profil</a>
                                        <form action="{{ route('admin.logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-rose-600 hover:bg-rose-50">Logout</button>
                                        </form>
                                    @else
                                        <a href="{{ route('seller.profile') }}" class="block px-4 py-2 text-slate-600 hover:bg-slate-50">Detail Profil</a>
                                        <form action="{{ route('seller.logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-rose-600 hover:bg-rose-50">Logout</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </nav>
                    @else
                        <div class="flex-1 flex items-center gap-6 min-w-full md:min-w-[55%]">
                            <form action="{{ route('catalog.index') }}" method="GET" class="flex-1 relative">
                                <div class="flex items-center gap-2 bg-slate-50 rounded-full px-4 py-2 ring-1 ring-purple-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 3.473 9.745l3.64 3.64a.75.75 0 1 0 1.06-1.06l-3.64-3.64A5.5 5.5 0 0 0 9 3.5Zm-4 5.5a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd" />
                                    </svg>
                                    <input
                                        type="text"
                                        name="q"
                                        id="globalSearch"
                                        value="{{ request('q') }}"
                                        placeholder="Cari produk, toko, kategori, lokasi..."
                                        class="bg-transparent flex-1 text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none"
                                        autocomplete="off"
                                    >
                                </div>
                                <div id="searchHistory" class="hidden absolute left-0 right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-lg text-sm text-slate-700 max-h-48 overflow-y-auto">
                                    <!-- History items injected via JS -->
                                </div>
                            </form>
                            <div class="flex items-center gap-6 text-sm font-medium text-slate-600">
                                <a href="{{ route('catalog.index') }}" class="hover:text-purple-800">Katalog</a>
                                <a href="{{ route('home') }}#features" class="hover:text-purple-800">Fitur</a>
                                <div class="relative">
                                    <button id="guestLoginToggle" class="inline-flex items-center gap-1 text-purple-700 hover:text-purple-900">
                                        Login
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.104l3.71-3.872a.75.75 0 1 1 1.08 1.04l-4.24 4.43a.75.75 0 0 1-1.08 0l-4.24-4.43a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div id="guestLoginDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-lg shadow-lg py-2 text-sm">
                                        <a href="{{ route('seller.login') }}" class="block px-4 py-2 text-slate-600 hover:bg-slate-50">Login Penjual</a>
                                        <a href="{{ route('admin.login') }}" class="block px-4 py-2 text-slate-600 hover:bg-slate-50">Login Admin</a>
                                    </div>
                                </div>
                                <a href="{{ route('sellers.register') }}" class="bg-purple-600 text-white px-5 py-2 rounded-full hover:bg-purple-700 font-semibold">Registrasi</a>
                            </div>
                        </div>
                    @endif
                </div>
            </header>

            <main class="flex-1 p-4">
                @yield('content')
            </main>
        </div>

    <script>
        const profileToggle = document.getElementById('profileToggle');
        const profileDropdown = document.getElementById('profileDropdown');
        const guestLoginToggle = document.getElementById('guestLoginToggle');
        const guestLoginDropdown = document.getElementById('guestLoginDropdown');
        const globalSearch = document.getElementById('globalSearch');
        const searchHistoryBox = document.getElementById('searchHistory');
        const SEARCH_HISTORY_KEY = 'sellora_search_history';

        profileToggle?.addEventListener('click', () => {
            profileDropdown?.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!profileToggle?.contains(event.target) && !profileDropdown?.contains(event.target)) {
                profileDropdown?.classList.add('hidden');
            }
            if (!guestLoginToggle?.contains(event.target) && !guestLoginDropdown?.contains(event.target)) {
                guestLoginDropdown?.classList.add('hidden');
            }
            if (!searchHistoryBox?.contains(event.target) && !globalSearch?.contains(event.target)) {
                searchHistoryBox?.classList.add('hidden');
            }
        });

        guestLoginToggle?.addEventListener('click', () => {
            guestLoginDropdown?.classList.toggle('hidden');
        });

        function getHistory() {
            try {
                const raw = localStorage.getItem(SEARCH_HISTORY_KEY);
                return raw ? JSON.parse(raw) : [];
            } catch (e) {
                return [];
            }
        }

        function saveHistory(term) {
            const cleanTerm = term.trim();
            if (!cleanTerm) return;

            const current = getHistory().filter((item) => item.toLowerCase() !== cleanTerm.toLowerCase());
            current.unshift(cleanTerm);
            const limited = current.slice(0, 7);
            localStorage.setItem(SEARCH_HISTORY_KEY, JSON.stringify(limited));
        }

        function renderHistory() {
            if (!searchHistoryBox || !globalSearch) return;
            const history = getHistory();
            if (!history.length) {
                searchHistoryBox.classList.add('hidden');
                searchHistoryBox.innerHTML = '';
                return;
            }

            const items = history.map((item) => `
                <div class="flex items-center justify-between px-4 py-2 hover:bg-slate-50">
                    <button type="button" class="flex-1 text-left" data-history-item="${item.replace(/"/g, '&quot;')}">${item}</button>
                    <button type="button" class="ml-3 text-slate-400 hover:text-rose-500" aria-label="Hapus riwayat" data-history-remove="${item.replace(/"/g, '&quot;')}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.22 4.22a.75.75 0 0 1 1.06 0L10 8.94l4.72-4.72a.75.75 0 1 1 1.06 1.06L11.06 10l4.72 4.72a.75.75 0 0 1-1.06 1.06L10 11.06l-4.72 4.72a.75.75 0 0 1-1.06-1.06L8.94 10 4.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `).join('');

            searchHistoryBox.innerHTML = `
                <div class="flex items-center justify-between px-4 py-2 text-xs font-semibold text-slate-500 border-b border-slate-100">
                    <span>Riwayat pencarian</span>
                    <button type="button" id="clearHistoryBtn" class="text-rose-600 hover:text-rose-700">Hapus semua</button>
                </div>
                ${items}
            `;
            searchHistoryBox.classList.remove('hidden');

            searchHistoryBox.querySelectorAll('[data-history-item]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const value = btn.getAttribute('data-history-item') || '';
                    globalSearch.value = value;
                    searchHistoryBox.classList.add('hidden');
                    globalSearch.closest('form')?.submit();
                });
            });

            searchHistoryBox.querySelectorAll('[data-history-remove]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const value = btn.getAttribute('data-history-remove') || '';
                    const updated = getHistory().filter((item) => item.toLowerCase() !== value.toLowerCase());
                    localStorage.setItem(SEARCH_HISTORY_KEY, JSON.stringify(updated));
                    renderHistory();
                });
            });

            const clearBtn = searchHistoryBox.querySelector('#clearHistoryBtn');
            clearBtn?.addEventListener('click', () => {
                localStorage.removeItem(SEARCH_HISTORY_KEY);
                renderHistory();
            });
        }

        globalSearch?.addEventListener('focus', renderHistory);

        globalSearch?.closest('form')?.addEventListener('submit', () => {
            saveHistory(globalSearch.value || '');
        });
    </script>
    @stack('scripts')
</body>
</html>
