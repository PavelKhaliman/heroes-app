<?php

namespace App\Http\Requests\Admin\Clan\Coslist;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nicname' => ['required','string'],
            'guild' => ['nullable','string'],
            'master' => ['nullable','string'],
            'reason' => ['required','string'],
            'repayment' => ['required','string'], 
        ];
    }
}
