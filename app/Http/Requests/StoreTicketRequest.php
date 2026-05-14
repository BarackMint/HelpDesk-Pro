<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'priority'    => ['required', 'in:low,medium,high,critical'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'A ticket title is required.',
            'title.min'            => 'Title must be at least 5 characters.',
            'description.required' => 'Please describe the issue.',
            'description.min'      => 'Description must be at least 10 characters.',
            'priority.required'    => 'Please select a priority level.',
            'priority.in'          => 'Invalid priority selected.',
            'category_id.exists'   => 'Selected category does not exist.',
        ];
    }
}