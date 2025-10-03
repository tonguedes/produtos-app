<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Novo Produto</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow rounded p-6">
            @csrf

            <div class="mb-4">
                <label class="block font-medium">Nome</label>
                <input type="text" name="name" class="mt-1 w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Descrição</label>
                <textarea name="description" class="mt-1 w-full border rounded p-2"></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Preço</label>
                <input type="number" step="0.01" name="price" class="mt-1 w-full border rounded p-2" required>
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
                <label class="block mb-2 font-semibold">Imagem</label>
                <input type="file" name="image" id="imageInput  " class="w-full border rounded px-3 py-2"
                    accept="image/*">
                <div class="mt-3">
                    <img id="previewImage" class="w-40 h-40 object-cover rounded hidden">
                </div>

{{-- 
                <!-- Galeria (múltiplas imagens) -->
                <label class="block font-bold mb-1">Imagens adicionais:</label>
                <input type="file" name="images[]" multiple class="w-full border p-2 mb-4">
            </div> --}}

            <div class="flex justify-end space-x-2">
                <a href="{{ route('products.index') }}"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</a>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Salvar</button>
            </div>
        </form>
    </div>


    <script>
        document.getElementById('imageInput')?.addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                const preview = document.getElementById('previewImage');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
