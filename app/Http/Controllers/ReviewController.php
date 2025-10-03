<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;




class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $data['user_id'] = auth()->id();

        $product->reviews()->create($data);

        return back()->with('success', 'Avaliação adicionada com sucesso!');
    }
}