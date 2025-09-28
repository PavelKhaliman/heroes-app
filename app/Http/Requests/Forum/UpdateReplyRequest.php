<?php

namespace App\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'body' => ['required','string'],
            'images' => ['nullable','array','max:10'],
            'images.*' => ['file','image','mimes:jpg,jpeg,png,webp,gif','max:5120'],
        ];
    }
}


