<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreGuestRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:128'],
            'surname' => ['required', 'string', 'max:128'],
            'email' => ['required', 'unique:guests,email', 'string', 'max:128', 'email:rfc'],
            'phone' => ['required', 'unique:guests,phone', 'string', 'max:25', new PhoneNumber],
            'country' => ['nullable', 'string', 'max:128'],
        ];
    }
}
