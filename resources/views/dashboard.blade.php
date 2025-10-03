<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">📊 Dashboard</h2>
    </x-slot>

    {{-- Cards de estatísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Produtos</h3>
            <p class="text-4xl font-bold mt-2">{{ $totalProducts }}</p>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Categorias</h3>
            <p class="text-4xl font-bold mt-2">{{ $totalCategories }}</p>
        </div>
        <div class="bg-gradient-to-r from-pink-500 to-rose-600 text-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Últimos 7 dias</h3>
            <p class="text-4xl font-bold mt-2">{{ $latestProducts->count() }}</p>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Produtos por Categoria</h3>
            <canvas id="productsByCategoryChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Produtos criados por mês</h3>
            <canvas id="productsByMonthChart"></canvas>
        </div>
    </div>

    {{-- Últimos Produtos --}}
    <div class="bg-white p-6 rounded-lg shadow mt-8">
        <h3 class="text-lg font-semibold mb-4">Últimos Produtos</h3>
        <ul class="divide-y divide-gray-200">
            @forelse($latestProducts as $product)
                <li class="py-2 flex justify-between items-center">
                    <span>{{ $product->name }}</span>
                    <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline">Ver</a>
                </li>
            @empty
                <li>Nenhum produto cadastrado ainda.</li>
            @endforelse
        </ul>
    </div>

    @vite('resources/js/dashboard.js')
</x-app-layout>

