<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|max:15',
            'email'    => 'required|email|unique:users|max:25',
            'password' => 'required|confirmed|min:8',
            'role'     => 'nullable|in:admin,librarian',
        ];
    }
}
