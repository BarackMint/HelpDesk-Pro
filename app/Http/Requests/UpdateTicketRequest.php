<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'       => ['sometimes', 'required', 'string', 'min:5', 'max:255'],
            'description' => ['sometimes', 'required', 'string', 'min:10'],
            'priority'    => ['sometimes', 'required', 'in:low,medium,high,critical'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'status'      => ['sometimes', 'required', 'in:open,in_progress,resolved,closed'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'A ticket title is required.',
            'title.min'            => 'Title must be at least 5 characters.',
            'description.required' => 'Please describe the issue.',
            'description.min'      => 'Description must be at least 10 characters.',
            'priority.in'          => 'Invalid priority selected.',
            'category_id.exists'   => 'Selected category does not exist.',
            'status.in'            => 'Invalid status selected.',
            'assigned_to.exists'   => 'Selected user does not exist.',
        ];
    }
}