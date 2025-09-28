<?php

namespace App\Http\Requests\Gallery\Photo;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'image' => ['nullable','image','max:5120'],
            'description' => ['nullable','string'],
        ];
    }
}


