<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'description' => 'required|string'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
