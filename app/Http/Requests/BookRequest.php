<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'          => 'required|string|max:255',
            'subject'        => 'required|string|max:255',
            'category'       => 'required|in:textbook,reference book,research,thesis',
            'author'         => 'required|string|max:255',
            'pages'          => 'required|integer|min:1',
            'language'       => 'required|in:khmer,english,chinese',
            'published_date' => 'required|date',
            'quantity'       => 'required|integer|min:0',
            'location'       => 'required|string|max:50',
            // required on create, optional on update (keep existing image)
            'image'          => $this->isMethod('POST') ? 'required|image|max:2048' : 'nullable|image|max:2048',
            'file'           => 'nullable|mimes:pdf|max:20480',
        ];
    }
}
