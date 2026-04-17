<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $branchId = $this->route('branch')->id;

        return [
            'business_unit_id' => ['sometimes', 'required', 'exists:business_units,id'],
            'location_id' => ['sometimes', 'required', 'exists:locations,id'],
            'code' => ['sometimes', 'required', 'string', 'max:50', Rule::unique('branches', 'code')->ignore($branchId)],
            'display_name' => ['sometimes', 'required', 'string', 'max:255'],
            'area_barangay' => ['nullable', 'string', 'max:255'],
            'spreadsheet_sheet_name' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'required', Rule::in(['active', 'inactive', 'closed'])],
            'opened_at' => ['nullable', 'date'],
            'closed_at' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string'],
            'product_line_ids' => ['nullable', 'array'],
            'product_line_ids.*' => ['exists:product_lines,id'],
        ];
    }   
}