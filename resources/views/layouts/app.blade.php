@props(['title' => config('app.name', 'Laravel')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif



</head>
<body class="h-screen flex bg-gray-100 font-sans">

    {{-- Sidebar --}}
 <aside class="w-64 bg-white shadow-lg flex-shrink-0 hidden md:block">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">{{ config('app.name', 'Dashboard') }}</h1>
            <nav class="space-y-2">
                <a href="{{ route('products.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('products.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    Produtos
                </a>
                <a href="{{ route('products.create') }}" class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('products.create') ? 'bg-gray-200 font-semibold' : '' }}">
                    Novo Produto
                </a>

                  <!-- Dropdown Exportar -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center space-x-2">
            <span>Exportar</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" @click.away="open = false"
             class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg py-1 z-10">
            <a href="{{ route('products.export.excel') }}"
               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                📊 Exportar Excel
            </a>
            <a href="{{ route('products.export.pdf') }}"
               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                📄 Exportar PDF
            </a>
        </div>
    </div>
            </nav>
        </div>
    </aside>

    {{-- Conteúdo principal --}}
    <div class="flex-1 flex flex-col overflow-auto">
        {{-- Header --}}
        @if (isset($header))
            <header class="bg-white shadow p-4">
                <div class="max-w-7xl mx-auto">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- Main --}}
        <main class="flex-1 max-w-7xl mx-auto p-6 w-full">
            {{ $slot }}
        </main>
    </div>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
