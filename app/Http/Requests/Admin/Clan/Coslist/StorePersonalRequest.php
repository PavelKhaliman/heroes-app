<?php

namespace App\Http\Requests\Admin\Clan\Coslist;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nicname' => ['required','string'],
            'guild' => ['nullable','string'],
            'reason' => ['required','string'],
            'repayment' => ['required','string'],
        ];
    }
}


