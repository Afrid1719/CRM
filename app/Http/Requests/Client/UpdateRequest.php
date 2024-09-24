<?php

namespace App\Http\Requests\Client;

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
        $client = $this->route('client');
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', function ($attribute, $value, $fail) use ($client) {
                if ($client && $client->email !== $value) {
                    $fail('The email cannot be changed.');
                }
            }],
            'vat' => ['required', 'integer', 'gt:0', 'lt:1000000', 'unique:App\Models\Client'],
            'address' => ['required', 'string']
        ];
    }
}
