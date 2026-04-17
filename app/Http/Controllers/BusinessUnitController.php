<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBusinessUnitRequest;
use App\Http\Requests\UpdateBusinessUnitRequest;
use App\Models\BusinessUnit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BusinessUnitController extends Controller
{
    public function index(): View
    {
        $businessUnits = BusinessUnit::latest()->paginate(10);

        return view('business-units.index', compact('businessUnits'));
    }

    public function create(): View
    {
        return view('business-units.create');
    }

    public function store(StoreBusinessUnitRequest $request): RedirectResponse
    {
        BusinessUnit::create($request->validated());

        return redirect()
            ->route('business-units.index')
            ->with('success', 'Business unit created successfully.');
    }

    public function show(BusinessUnit $business_unit): View
    {
        return view('business-units.show', ['businessUnit' => $business_unit]);
    }

    public function edit(BusinessUnit $business_unit): View
    {
        return view('business-units.edit', ['businessUnit' => $business_unit]);
    }

    public function update(UpdateBusinessUnitRequest $request, BusinessUnit $business_unit): RedirectResponse
    {
        $business_unit->update($request->validated());

        return redirect()
            ->route('business-units.index')
            ->with('success', 'Business unit updated successfully.');
    }
}