<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductLineRequest;
use App\Http\Requests\UpdateProductLineRequest;
use App\Models\ProductLine;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductLineController extends Controller
{
    public function index(): View
    {
        $productLines = ProductLine::latest()->paginate(10);

        return view('product-lines.index', compact('productLines'));
    }

    public function create(): View
    {
        return view('product-lines.create');
    }

    public function store(StoreProductLineRequest $request): RedirectResponse
    {
        ProductLine::create($request->validated());

        return redirect()
            ->route('product-lines.index')
            ->with('success', 'Product line created successfully.');
    }

    public function show(ProductLine $product_line): View
    {
        return view('product-lines.show', ['productLine' => $product_line]);
    }

    public function edit(ProductLine $product_line): View
    {
        return view('product-lines.edit', ['productLine' => $product_line]);
    }

    public function update(UpdateProductLineRequest $request, ProductLine $product_line): RedirectResponse
    {
        $product_line->update($request->validated());

        return redirect()
            ->route('product-lines.index')
            ->with('success', 'Product line updated successfully.');
    }
}