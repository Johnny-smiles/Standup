<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->task->user_id === $this->user()->getKey() || $this->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
