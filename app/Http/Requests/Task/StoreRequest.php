<?php

namespace App\Http\Requests\Task;

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

    public function validationData()
    {
        $data = $this->all();
        $data['status'] = filter_var($data['status'], FILTER_VALIDATE_BOOLEAN);
        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:70', 'unique:App\Models\Task'],
            'description' => ['required', 'string', 'max:250'],
            'status' => ['nullable', 'boolean'],
            'assigned_to' => ['required', 'string', 'exists:App\Models\AppUser,id'],
            'for_client' => ['required', 'string', 'exists:App\Models\Client,id'],
            'related_to_project' => ['required', 'string', 'exists:App\Models\Project,id'],
        ];
    }
}
