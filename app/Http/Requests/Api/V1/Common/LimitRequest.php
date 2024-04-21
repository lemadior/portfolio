<?php

namespace App\Http\Requests\Api\V1\Common;

use Illuminate\Foundation\Http\FormRequest;

class LimitRequest extends FormRequest
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
            'limit' => 'sometimes|integer|gt:2'
        ];
    }
}
