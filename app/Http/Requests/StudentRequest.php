<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('student');

        return [
            'student_code'  => ['required', 'string', 'max:50', Rule::unique('students', 'student_code')->ignore($id)],
            'full_name'     => 'required|string|max:100',
            'gender'        => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'phone'         => ['required', 'string', 'max:50', Rule::unique('students', 'phone')->ignore($id)],
            'enroll_year'   => 'required|digits:4|integer|min:2000|max:' . now()->year,
            'degree_id'     => 'required|exists:degrees,id',
            'address'       => 'required|string|max:255',
            'image'         => 'nullable|image|max:2048',
            'status'        => 'required|in:active,inactive,graduated,suspended',
        ];
    }
}
