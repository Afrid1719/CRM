<?php

namespace App\Http\Requests\AppUser;

use App\Models\AppUser;
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
        $user = $this->route('user');
        return [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', function ($attribute, $value, $fail) use ($user) {
                // Ensure email is unchanged during update
                if ($user && $user->email !== $value) {
                    $fail('The email cannot be changed.');
                }
            }],
            'avatar' => ['nullable', 'url:https']
        ];
    }
}
