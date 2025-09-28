<?php

namespace App\Http\Requests\Guide;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'excerpt' => ['nullable','string','max:500'],
            'image' => ['nullable','image','max:5120'],
            'body' => ['required','string'],
        ];
    }
}


