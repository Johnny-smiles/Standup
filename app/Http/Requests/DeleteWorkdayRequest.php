<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteWorkdayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->workday->user_id === $this->user()->getKey() || $this->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
