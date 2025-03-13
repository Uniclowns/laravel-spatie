<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250|unique:roles,name,'.$this->role->id,
            'permissions' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
