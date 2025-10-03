<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between items-center">
            <!-- Título -->
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Produtos</h2>

            <div class="flex items-center space-x-6">
                <!-- Link para Dashboard -->
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline font-medium">
                    📊 Dashboard
                </a>

                <!-- Ícone de Favoritos com contador -->
                @auth
                    <a href="{{ route('products.index', ['favorites' => true]) }}" class="relative inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36
                                                     2 12.28 2 8.5
                                                     2 5.42 4.42 3 7.5 3c1.74 0 3.41.81
                                                     4.5 2.09C13.09 3.81 14.76 3 16.5 3
                                                     19.58 3 22 5.42 22 8.5c0 3.78-3.4
                                                     6.86-8.55 11.54L12 21.35z" />
                        </svg>
                        @if ($favoritesCount > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                                {{ $favoritesCount }}
                            </span>
                        @endif
                    </a>
                @endauth

                <!-- Logout -->
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                            Sair
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </x-slot>

    <!-- Campo de busca -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-6">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar produto..."
            class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
    </form>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Mensagem de sucesso -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Botão Novo Produto -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('products.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    ➕ Novo Produto
                </a>
            </div>

            <div class="flex gap-2 mb-4">
                <a href="{{ route('products.export.excel') }}"
                    class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700">
                    Exportar Excel
                </a>

                <a href="{{ route('products.export.pdf') }}"
                    class="bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700">
                    Exportar PDF
                </a>
            </div>


            <!-- Grid de Produtos -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <div class="bg-red shadow rounded-lg p-4 hover:shadow-lg transition-shadow flex flex-col">
                        <!-- Imagem -->
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-full h-100 object-cover rounded mb-3">
                        @else
                            <div class="w-full h-40 flex items-center justify-center bg-gray-100 rounded mb-3">
                                <span class="text-gray-500">Sem imagem</span>
                            </div>
                        @endif

                        <!-- Conteúdo -->
                        <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">
                            {{ $product->category->name ?? 'Sem categoria' }}
                        </p>
                        <p class="text-gray-700 font-medium mb-2">
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        </p>

                        <div class="mt-3 flex space-x-2">

                            {{-- Botão WhatsApp --}}
                            <a href="https://wa.me/5516999932309?text=Olá! Tenho interesse no produto: {{ urlencode($product->name) }} (R$ {{ number_format($product->price, 2, ',', '.') }})"
                                target="_blank"
                                class="flex items-center justify-center w-full bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20.52 3.48A11.88 11.88 0 0012 0C5.37 0 0 5.37 0 12c0 2.11.55 4.18 1.59 6.01L0 24l6.19-1.62A11.88 11.88 0 0012 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.19-3.48-8.52zM12 22c-1.91 0-3.77-.51-5.39-1.49l-.39-.23-3.68.96.98-3.59-.25-.4A9.95 9.95 0 012 12c0-5.51 4.49-10 10-10 2.67 0 5.18 1.04 7.07 2.93A9.93 9.93 0 0122 12c0 5.51-4.49 10-10 10z" />
                                </svg>
                                Pedir pelo WhatsApp
                            </a>

                        </div>
                        <h3 class="mt-2 font-bold text-lg flex items-center">
                            {{ $product->name }}
                            @php
                                $avg = round($product->averageRating()); // arredonda pra exibir estrelas
                            @endphp
                            <span class="ml-2 text-yellow-500">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= $avg ? '⭐' : '☆' }}
                                @endfor
                            </span>
                        </h3>


                        <!-- Estoque -->
                        <p class="text-sm text-gray-600 mb-2">
                            Estoque: <span class="font-semibold">{{ $product->stock }}</span>
                        </p>

                        <!-- Ações -->
                        <div class="mt-auto flex flex-col space-y-2">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('products.show', $product) }}"
                                    class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('products.edit', $product) }}"
                                    class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Excluir este produto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Excluir</button>
                                </form>
                            </div>

                            <!-- Favoritar -->
                            @auth
                                <form action="{{ route('products.favorite', $product->id) }}" method="POST"
                                    class="text-center">
                                    @csrf
                                    <button type="submit" class="text-pink-600 hover:underline">
                                        @if (auth()->user()->favorites->contains($product->id))
                                            💖 Remover dos Favoritos
                                        @else
                                            🤍 Adicionar aos Favoritos
                                        @endif
                                    </button>
                                </form>
                            @endauth

                            @guest
                                <a href="{{ route('login') }}" class="text-gray-400 hover:text-gray-600 text-center">
                                    🤍 Faça login para favoritar
                                </a>
                            @endguest



                        </div>

                        <!-- Atualizar Estoque -->
                        @auth
                            <form action="{{ route('products.updateStock', $product) }}" method="POST"
                                class="flex items-center space-x-2">
                                @csrf
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                    class="w-20 border rounded px-2 py-1">
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                    Atualizar
                                </button>
                            </form>

                        @endauth
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
