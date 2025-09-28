<?php

namespace App\Http\Requests\Social;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required','in:guide,photo'],
            'id' => ['required','integer'],
            'body' => ['required','string'],
            'redirect' => ['nullable','string'],
        ];
    }
}


