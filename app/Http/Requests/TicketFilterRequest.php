<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketFilterRequest extends FormRequest
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
		    'status' => ['nullable', Rule::in(['new', 'in_progress', 'resolved'])],
		    'date_from' => ['nullable', 'date'],
		    'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
		    'email' => ['email', 'nullable', 'string', 'max:255'],
		    'phone' => ['nullable', 'string', 'max:20'],
	    ];
    }
}
