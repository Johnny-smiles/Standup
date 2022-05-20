<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->task->user->getKey() === $this->user()->getKey() || $this->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
