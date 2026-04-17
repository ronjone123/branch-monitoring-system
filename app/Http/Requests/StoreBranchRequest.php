<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_unit_id' => ['required', 'exists:business_units,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'code' => ['required', 'string', 'max:50', 'unique:branches,code'],
            'display_name' => ['required', 'string', 'max:255'],
            'area_barangay' => ['nullable', 'string', 'max:255'],
            'spreadsheet_sheet_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive,closed'],
            'opened_at' => ['nullable', 'date'],
            'closed_at' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string'],
            'product_line_ids' => ['nullable', 'array'],
            'product_line_ids.*' => ['exists:product_lines,id'],
        ];
    }
}