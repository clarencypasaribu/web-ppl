<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sellora Platform')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('head')
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex flex-col">
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-purple-900 font-semibold">
                <img src="{{ asset('images/sellora-logo.png') }}" alt="Sellora" class="h-12 w-auto">
                <span class="sr-only">Sellora</span>
            </a>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
