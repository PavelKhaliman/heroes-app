<?php

namespace App\Http\Requests\Clan;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'age' => ['required','integer','min:1'],
            'nic_name' => ['required','string','max:255'],
            'level' => ['required','integer','min:1'],
            'strong' => ['required','integer','min:0'],
            'survival' => ['required','integer','min:0'],
            'prime_msk' => ['required','string','max:255'],
            'charecter_class' => ['required','string','max:255'],
            'info' => ['required','string'],
            'kos_list' => ['required','string','max:255'],
        ];
    }
}
