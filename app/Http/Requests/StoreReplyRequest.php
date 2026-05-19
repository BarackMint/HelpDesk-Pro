<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $rules = [
            'body' => ['required', 'string', 'min:3', 'max:5000'],
        ];

        // Only agents and admins can change status when replying
        if (auth()->user()->isAgent() || auth()->user()->isAdmin()) {
            $rules['status'] = ['nullable', 'in:open,in_progress,resolved,closed'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'body.required' => 'Reply cannot be empty.',
            'body.min'      => 'Reply must be at least 3 characters.',
            'body.max'      => 'Reply cannot exceed 5000 characters.',
            'status.in'     => 'Invalid status selected.',
        ];
    }
}