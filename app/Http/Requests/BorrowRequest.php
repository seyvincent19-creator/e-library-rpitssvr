<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BorrowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'     => 'required|exists:users,id',
            'book_id'     => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date'    => 'required|date|after:borrow_date',
        ];
    }

    public function messages(): array
    {
        return [
            'due_date.after' => 'Due date must be after the borrow date.',
        ];
    }
}
