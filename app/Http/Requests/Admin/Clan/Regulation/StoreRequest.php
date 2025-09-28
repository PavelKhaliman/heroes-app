<?php

namespace App\Http\Requests\Admin\Clan\Regulation;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'regulation' => ['required','string'],
        ];
    }
}
