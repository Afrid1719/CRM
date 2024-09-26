<?php

namespace App\Http\Requests\Project;

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
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:250'],
            'deadline' => ['nullable', 'date'],
            'assigned_user' => ['required', 'string', 'exists:App\Models\AppUser,id'],
            'assigned_client' => ['required', 'string', 'exists:App\Models\Client,id'],
            'status' => ['required', 'string', 'in:Open,In progress,Completed'],
        ];
    }
}
