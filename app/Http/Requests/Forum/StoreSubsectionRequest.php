<?php

namespace App\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubsectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        $sectionId = $this->route('section')->id ?? null;
        return [
            'title' => ['required','string','max:255'],
            'slug' => ['required','string','max:255','unique:forum_subsections,slug,NULL,id,forum_section_id,'.$sectionId],
            'description' => ['nullable','string'],
            'position' => ['nullable','integer','min:0'],
        ];
    }
}


