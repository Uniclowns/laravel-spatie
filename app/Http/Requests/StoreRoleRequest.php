<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250|unique:roles,name',
            'permissions' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
