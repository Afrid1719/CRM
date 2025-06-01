<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateRequest extends FormRequest
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
        $task = $this->route('task');

        return [
            'title' => ['required', 'string', function ($attribute, $value, $fail) use ($task) {
                if ($task && $task->title !== $value) {
                    $fail('The title cannot be changed.');
                }
            }],
            'description' => ['nullable', 'string', 'max:250'],
            'status' => ['nullable', 'boolean'],
            'assinged_to' => ['nullable', 'string', 'exists:App\Models\User,id'],
            'for_client' => ['nullable', 'string', 'exists:App\Models\Client,id'],
            'related_to_project' => ['nullable', 'string', 'exists:App\Models\Project,id'],
            'attachments.*' => [
                'sometimes', // Only validate if the field is present
                'file',      // Ensure it's a file
                'mimes:jpg,jpeg,png,pdf', // Allowed file types
                'max:5120',  // Maximum file size in kilobytes (5MB)
            ],
        ];
    }
}
