<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use App\Models\BusinessUnit;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\ProductLine;

class BranchController extends Controller
{
    public function index(): View
    {
        $branches = Branch::with(['businessUnit', 'location'])
            ->latest()
            ->paginate(10);

        return view('branches.index', compact('branches'));
    }

    public function create(): View
    {
        $businessUnits = BusinessUnit::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $productLines = ProductLine::orderBy('name')->get();

        return view('branches.create', compact('businessUnits', 'locations', 'productLines'));
    }

    public function store(StoreBranchRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $productLineIds = $data['product_line_ids'] ?? [];
        unset($data['product_line_ids']);

        $branch = Branch::create($data);
        $branch->productLines()->sync($productLineIds);

        return redirect()
            ->route('branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch): View
    {
        $businessUnits = BusinessUnit::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $productLines = ProductLine::orderBy('name')->get();

        $branch->load('productLines');

        return view('branches.edit', compact('branch', 'businessUnits', 'locations', 'productLines'));
    }

    public function update(UpdateBranchRequest $request, Branch $branch): RedirectResponse
    {
        $data = $request->validated();

        $productLineIds = $data['product_line_ids'] ?? null;
        unset($data['product_line_ids']);

        if (isset($data['status']) && $data['status'] === 'closed' && !$branch->closed_at) {
            $data['closed_at'] = now();
        }

        $branch->update($data);

        if (is_array($productLineIds)) {
            $branch->productLines()->sync($productLineIds);
        }

        return redirect()
            ->route('branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        $branch->delete();

        return redirect()
            ->route('branches.index')
            ->with('success', 'Branch deleted successfully.');
    }
    public function show(Branch $branch): View
    {
        $branch->load(['businessUnit', 'location', 'productLines']);

        return view('branches.show', compact('branch'));
    }
}