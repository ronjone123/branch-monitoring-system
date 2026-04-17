<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Models\ProductLine;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::with('productLine')
            ->latest()
            ->paginate(10);

        return view('brands.index', compact('brands'));
    }

    public function create(): View
    {
        $productLines = ProductLine::orderBy('name')->get();

        return view('brands.create', compact('productLines'));
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        Brand::create($request->validated());

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function show(Brand $brand): View
    {
        $brand->load('productLine');

        return view('brands.show', compact('brand'));
    }

    public function edit(Brand $brand): View
    {
        $productLines = ProductLine::orderBy('name')->get();

        return view('brands.edit', compact('brand', 'productLines'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        $brand->update($request->validated());

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand updated successfully.');
    }
}