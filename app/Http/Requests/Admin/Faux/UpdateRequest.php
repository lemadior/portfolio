<?php

namespace App\Http\Requests\Admin\Faux;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'group_id' => 'nullable|integer|exists:groups,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'course_ids' => 'required|array|min:1',
            'course_ids.*' => 'required|integer|exists:courses,id'
        ];
    }
}
