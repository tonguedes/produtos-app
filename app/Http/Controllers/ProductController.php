<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    public function __construct()
    {
        // Todas as rotas exigem login
        $this->middleware('auth');
    }

    // Index com filtro de usuário/admin
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = auth()->user();

        $products = Product::with(['category', 'reviews'])
            ->when(!$user->is_admin, function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(9);

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        return view('products.create');
    }

    // Store: vincula usuário logado ao produto
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'stock'       => 'nullable|integer|min:0',
        ]);

        // Salva usuário logado
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'stock'       => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index');
    }

    // Favoritos
    public function toggleFavorite(Product $product)
    {
        $user = auth()->user();

        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->detach($product->id);
        } else {
            $user->favorites()->attach($product->id);
        }

        return back();
    }

    // Atualizar estoque
    public function updateStock(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->stock = $validated['stock'];
        $product->save();

        return back()->with('success', 'Estoque atualizado com sucesso!');
    }

    // Exportações
    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'produtos.xlsx');
    }

    public function exportPdf()
    {
        $products = Product::with('category')->get();
        $pdf = Pdf::loadView('exports.products_pdf', compact('products'))->setPaper('a4', 'portrait');
        return $pdf->download('produtos.pdf');
    }
}
