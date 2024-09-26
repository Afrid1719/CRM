<?php

namespace App\Http\Requests\Task;

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
        $task = $this->route('task');
        return [
            'title' => ['required', 'string', function ($attribute, $value, $fail) use ($task) {
                if ($task && $task->title !== $value) {
                    $fail('The title cannot be changed.');
                }
            }],
            'description' => ['required', 'string', 'max:250'],
            'status' => ['nullable', 'boolean'],
            'assinged_to' => ['required', 'string', 'exists:App\Models\AppUser,id'],
            'for_client' => ['required', 'string', 'exists:App\Models\Client,id'],
            'related_to_project' => ['required', 'string', 'exists:App\Models\Project,id'],
        ];
    }
}
