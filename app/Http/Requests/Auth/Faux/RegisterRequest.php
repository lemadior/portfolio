<?php

namespace App\Http\Requests\Auth\Faux;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Faux\Auth\ConfirmRule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
        $password = '';

        if ($this->request->has('password')) {
            $password = $this->request->get('password');
        }

        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => [
                'required',
                'string',
                Password::min(User::MIN_PASSWORD_LENGTH)
                    ->max(User::MAX_PASSWORD_LENGTH)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'confirm' => ['required', 'string', new ConfirmRule($password)]
        ];
    }
}
