<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function query()
    {
        return Product::query()->with('category');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Categoria',
            'Preço',
            'Estoque',
            'Criado em',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            optional($product->category)->name,
            number_format($product->price, 2, ',', '.'),
            $product->stock,
            $product->created_at?->format('d/m/Y H:i'),
        ];
    }
}
