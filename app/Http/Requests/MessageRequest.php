<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MessageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'conversation_id' => [Rule::requiredIf(fn() => $this->isMethod('POST')), Rule::exists('conversations', 'id')],
            'body' => [Rule::requiredIf(fn() => $this->file === null), 'string'],
            'file' => [Rule::requiredIf(fn() => $this->body === null), 'file', 'mime:mp4,pdf,jpg,png']
        ];
    }
}
