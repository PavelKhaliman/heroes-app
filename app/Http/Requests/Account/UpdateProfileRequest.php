<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable','string','max:255'],
            'nickname' => ['nullable','string','max:255'],
            'character_class' => ['nullable','string','max:255'],
        ];
    }
}


