<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
	public function rules(): array
	{
		return [
			'name' => ['required', 'string', 'max:255'],
			'phone' => ['nullable', 'string', 'regex:/^\+[1-9]\d{1,14}$/'],
			'email' => ['nullable', 'email', 'max:255'],
			'subject' => ['required', 'string', 'max:255'],
			'body' => ['required', 'string', 'max:5000'],
			'files' => ['nullable', 'array', 'max:5'],
			'files.*' => ['file', 'max:10240'],
		];
	}

	/**
	 * @return array<string, string>
	 */
	public function messages(): array
	{
		return [
			'phone.regex' => 'Номер телефона должен быть в формате E.164 (например, +79001234567).',
			'files.max' => 'Максимум 5 файлов.',
			'files.*.max' => 'Размер файла не должен превышать 10 МБ.',
		];
	}
}
