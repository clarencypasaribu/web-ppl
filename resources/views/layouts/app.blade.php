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
                    <span class="text-lg font-semibold text-purple-900">Sellora Platform</span>
                </a>
                <nav class="flex flex-wrap gap-4 text-sm font-medium text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-purple-800">Katalog</a>
                    <a href="{{ route('dashboard.platform') }}" class="hover:text-purple-800">Dashboard</a>
                    <a href="{{ route('products.create') }}" class="hover:text-purple-800">Upload Produk</a>
                    <a href="{{ route('products.index') }}" class="hover:text-purple-800">Laporan</a>
                    <a href="{{ route('sellers.verifications') }}" class="hover:text-purple-800">Alert</a>
                    <a href="{{ route('seller.home') }}" class="hover:text-purple-800">Profile</a>
                </nav>
            </div>
        </header>

        <main class="flex-1 p-4">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
