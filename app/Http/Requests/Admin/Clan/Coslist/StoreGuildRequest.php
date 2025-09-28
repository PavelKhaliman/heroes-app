<?php

namespace App\Http\Requests\Admin\Clan\Coslist;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuildRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guild' => ['required','string'],
            'master' => ['required','string'],
            'reason' => ['required','string'],
            'repayment' => ['required','string'],
        ];
    }
}


