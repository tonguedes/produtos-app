@props(['title' => config('app.name', 'Laravel')])

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @livewireStyles


    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    {{-- Vite (se estiver usando) --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Se não usa Vite, remova ou ajuste --}}
    @endif
</head>
<body class="font-sans antialiased bg-gray-100">
@livewireScripts

    <div class="min-h-screen flex flex-col">
        {{-- Nav simples --}}
        <nav class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div>
                        <a href="{{ url('/') }}" class="text-lg font-bold">{{ config('app.name', 'Laravel') }}</a>
                    </div>

                    <div class="space-x-4">
                        @auth
                            <span class="text-sm">Olá, {{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm underline">Sair</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm underline">Entrar</a>
                            <a href="{{ route('register') }}" class="text-sm underline">Registrar</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        {{-- Header (opcional) --}}
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- Conteúdo --}}
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 w-full flex-1">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
</body>
</html>
