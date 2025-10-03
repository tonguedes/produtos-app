<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $product->name }}</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded p-6">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-64 object-cover rounded mb-4">
            @endif

            <h3 class="text-2xl font-bold mb-2">{{ $product->name }}</h3>
            <p class="text-gray-700 mb-2">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
            <p class="text-gray-600 mb-4">{{ $product->description }}</p>

            <div class="flex space-x-2">
                <a href="{{ route('products.edit', $product) }}"
                    class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Editar</a>
                <a href="{{ route('products.index') }}"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Voltar</a>
            </div>

            @auth
                <form action="{{ route('products.reviews.store', $product) }}" method="POST" class="mb-6">
                    @csrf
                    <label for="rating" class="block font-bold">Sua nota:</label>
                    <select name="rating" id="rating" class="border rounded px-2 py-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                        @endfor
                    </select>

                    <textarea name="comment" rows="3" class="w-full border rounded px-3 py-2 mt-2"
                        placeholder="Escreva um comentário (opcional)"></textarea>

                    <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">
                        Enviar Avaliação
                    </button>
                </form>
            @endauth
            

            @auth
            <h3 class="text-lg font-bold mb-2">Avaliações:</h3>
            @if ($product->reviews->count())
                @foreach ($product->reviews as $review)
                    <div class="border-b py-2">
                        <p class="font-semibold">{{ $review->user->name }}
                            <span class="text-yellow-500">
                                {{ str_repeat('⭐', $review->rating) }}
                            </span>
                        </p>
                        <p>{{ $review->comment }}</p>
                        <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500">Nenhuma avaliação ainda.</p>
            @endif
            @endauth


        </div>


    </div>
</x-app-layout>
