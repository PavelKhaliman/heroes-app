<?php

namespace App\Http\Requests\Clan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $sqlPattern = '/(select\s+.*from|union\s+select|insert\s+into|update\s+.*set|delete\s+from|drop\s+table|--|\/\*|\*\/|;)/i';

        return [
            'name' => ['bail','required','string','min:2','max:20'],
            'age' => ['bail','required','integer','min:12','max:100'],
            'nic_name' => ['bail','required','string','min:2','max:32', 'regex:/^[A-Za-zА-Яа-я0-9 _.-]+$/u'],
            'level' => ['bail','required','integer','min:1','max:315'],
            'strong' => ['bail','required','integer','min:0','max:100000000'],
            'survival' => ['bail','required','integer','min:0','max:10000000'],
            'prime_msk' => ['bail','required','string','min:3','max:50', 'not_regex:'.$sqlPattern],
            'charecter_class' => ['bail','required','string','min:2','max:32', 'regex:/^[A-Za-zА-Яа-я0-9 _.-]+$/u'],
            'info' => ['bail','required','string','min:2','max:2000', 'not_regex:'.$sqlPattern],
            'kos_list' => ['bail','required','string','min:2','max:255', 'not_regex:'.$sqlPattern],
            // honeypot field (must be empty)
            'website' => ['nullable','string','size:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => is_string($this->input('name')) ? trim($this->input('name')) : $this->input('name'),
            'nic_name' => is_string($this->input('nic_name')) ? trim($this->input('nic_name')) : $this->input('nic_name'),
            'prime_msk' => is_string($this->input('prime_msk')) ? trim($this->input('prime_msk')) : $this->input('prime_msk'),
            'charecter_class' => is_string($this->input('charecter_class')) ? trim($this->input('charecter_class')) : $this->input('charecter_class'),
            'kos_list' => is_string($this->input('kos_list')) ? trim($this->input('kos_list')) : $this->input('kos_list'),
        ]);
    }

    public function messages(): array
    {
        return [
            'nic_name.regex' => 'Ник может содержать только буквы, цифры, пробел, _, ., -',
            'charecter_class.regex' => 'Класс может содержать только буквы, цифры, пробел, _, ., -',
            'info.min' => 'Опишите о себе подробнее (минимум 20 символов).',
            'website.size' => 'Ошибка проверки. Попробуйте ещё раз.',
            'prime_msk.not_regex' => 'Недопустимое содержимое поля Прайм.',
            'info.not_regex' => 'Недопустимое содержимое поля О себе.',
            'kos_list.not_regex' => 'Недопустимое содержимое поля КОСы.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            $age = (int) $this->input('age');
            $level = (int) $this->input('level');
            $strong = (int) $this->input('strong');
            $survival = (int) $this->input('survival');
            $name = trim((string) $this->input('name'));
            $nick = trim((string) $this->input('nic_name'));
            $prime = trim((string) $this->input('prime_msk'));
            $class = trim((string) $this->input('charecter_class'));
            $kos = trim((string) $this->input('kos_list'));
            $info = trim((string) $this->input('info'));

            $lowNums = [$age <= 1, $level <= 1, $strong <= 1, $survival <= 1];
            $ones = [($name === '1'), ($nick === '1'), ($prime === '1'), ($class === '1'), ($kos === '1')];

            if (count(array_filter($lowNums)) === 4 && count(array_filter($ones)) >= 3 && strlen($info) < 30) {
                $v->errors()->add('info', 'Заявка выглядит как спам. Заполните поля корректными данными.');
            }
        });
    }
}
