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
    <div class="min-h-screen flex flex-col">
        <header class="sticky top-0 z-10 bg-white border-b border-slate-100">
            <div class="max-w-6xl mx-auto px-4 py-3 flex flex-wrap gap-4 items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/sellora-logo.png') }}" alt="Sellora" class="h-8 w-auto">
                </a>
                <nav class="flex flex-wrap gap-4 text-sm font-medium text-slate-600 items-center">
                    <a href="{{ route('catalog.index') }}" class="hover:text-purple-800">Katalog Produk</a>
                    <a href="{{ route('seller.home') }}" class="hover:text-purple-800">Dashboard</a>
                    <a href="{{ route('products.create') }}" class="hover:text-purple-800">Upload Produk</a>
                    <a href="{{ route('reports.seller') }}" class="hover:text-purple-800">Laporan</a>
                    <a href="{{ route('alerts.orders') }}" class="hover:text-purple-800">Alert</a>
                    <div class="relative">
                        <button id="profileToggle" class="inline-flex items-center gap-1 text-purple-700 hover:text-purple-900">
                            Profile
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.104l3.71-3.872a.75.75 0 1 1 1.08 1.04l-4.24 4.43a.75.75 0 0 1-1.08 0l-4.24-4.43a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-lg shadow-lg py-2 text-sm">
                            <a href="{{ route('seller.home') }}" class="block px-4 py-2 text-slate-600 hover:bg-slate-50">Detail Profil</a>
                            <form action="{{ route('seller.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-rose-600 hover:bg-rose-50">Logout</button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <main class="flex-1 p-4">
            @yield('content')
        </main>
    </div>

    <script>
        const profileToggle = document.getElementById('profileToggle');
        const profileDropdown = document.getElementById('profileDropdown');

        profileToggle?.addEventListener('click', () => {
            profileDropdown?.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!profileToggle?.contains(event.target) && !profileDropdown?.contains(event.target)) {
                profileDropdown?.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
