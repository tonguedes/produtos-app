<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Produto</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow rounded p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium">Nome</label>
                <input type="text" name="name" value="{{ $product->name }}" class="mt-1 w-full border rounded p-2"
                    required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Descrição</label>
                <textarea name="description" class="mt-1 w-full border rounded p-2">{{ $product->description }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Preço</label>
                <input type="number" step="0.01" name="price" value="{{ $product->price }}"
                    class="mt-1 w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Categoria</label>
                <select name="category_id" class="w-full border rounded px-3 py-2">
                    <option value="">Selecione...</option>
                    @foreach (\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}"
                            {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-4">
                <label class="block font-medium">Imagem</label>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-32 object-cover mb-2 rounded">
                @endif
                <input type="file" name="image" class="mt-1 w-full border rounded p-2">
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('products.index') }}"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</a>
                <button type="submit"
                    class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Atualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
