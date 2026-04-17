<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductLineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productLineId = $this->route('product_line')->id;

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('product_lines', 'code')->ignore($productLineId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}