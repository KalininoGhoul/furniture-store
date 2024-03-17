<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SignUpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => ['required', Rule::unique(User::class, 'login')],

            'password' => Password::min(6)
                ->max(20)
                ->letters()
                ->numbers()
                ->symbols()
                ->mixedCase(),
        ];
    }
}
