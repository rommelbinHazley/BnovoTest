<?php

namespace App\Http\Requests;

use App\Models\Guest;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property Guest $guest
 */
class UpdateGuestRequest extends FormRequest
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
            'email' => ['required', Rule::unique('guests', 'email')->ignore($this->guest->getKey()), 'string', 'max:128', 'email:rfc'],
            'phone' => ['required', Rule::unique('guests', 'phone')->ignore($this->guest->getKey()), 'string', 'max:25', new PhoneNumber],
            'country' => ['nullable', 'string', 'max:128'],
        ];
    }
}
