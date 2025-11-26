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
        $navLinks = [
            ['label' => 'Home', 'route' => 'home', 'icon' => '🏠'],
            ['label' => 'Katalog Publik', 'route' => 'catalog.index', 'icon' => '🛒'],
            ['label' => 'Dashboard Penjual', 'route' => 'seller.home', 'icon' => '📈'],
            ['label' => 'Kelola Produk', 'route' => 'products.index', 'icon' => '📦'],
        ];
    @endphp
    <div>
        <aside id="app-sidebar" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-100 shadow-xl transform -translate-x-full transition-transform duration-200 z-30 flex flex-col">
            <div class="px-6 py-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-xs tracking-[0.4em] uppercase text-indigo-500 font-semibold">Sellora</p>
                    <h2 class="text-2xl font-semibold mt-2">Navigation</h2>
                </div>
                <button id="sidebarClose" class="text-slate-400 hover:text-slate-900">
                    ✕
                </button>
            </div>
            <nav class="px-4 py-6 space-y-1 text-sm flex-1 overflow-y-auto">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100 text-slate-600">
                        <span>{{ $link['icon'] }}</span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>
        </aside>

        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 hidden z-20"></div>

        <div id="app-content" class="min-h-screen transition-all duration-200">
            <header class="sticky top-0 z-10 bg-white border-b border-slate-100 px-4 py-3 flex items-center justify-between">
                <button id="sidebarToggle" class="inline-flex items-center gap-2 bg-slate-900 text-white px-3 py-2 rounded-lg">
                    ☰
                    <span class="text-sm font-medium">Menu</span>
                </button>
                <div class="flex items-center gap-3 text-sm">
                    <span class="text-slate-500">Sellora Platform</span>
                    <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800">Home</a>
                </div>
            </header>

            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('app-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const content = document.getElementById('app-content');
        let sidebarVisible = false;

        const renderSidebar = () => {
            if (!sidebar) return;
            const isDesktop = window.innerWidth >= 1024;
            if (sidebarVisible) {
                sidebar.classList.remove('-translate-x-full');
                if (isDesktop) {
                    overlay?.classList.add('hidden');
                } else {
                    overlay?.classList.remove('hidden');
                }
                content?.classList.add('lg:pl-64');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay?.classList.add('hidden');
                content?.classList.remove('lg:pl-64');
            }
        };

        const closeSidebar = () => {
            sidebarVisible = false;
            renderSidebar();
        };

        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            sidebarVisible = !sidebarVisible;
            renderSidebar();
        });

        document.getElementById('sidebarClose')?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        window.addEventListener('resize', () => {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
