<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DegreeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'majors'         => 'required|string|max:255',
            'duration_years' => 'required|string|in:1 year,2 years,4 years,4.5 years',
            'study_time'     => 'required|string|max:25',
            'degree_level'   => 'required|in:associate,bachelor,technical',
            'generation'     => 'required|string|max:25',
        ];
    }
}
