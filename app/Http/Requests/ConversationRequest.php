<?php

namespace App\Http\Requests;

use App\Enums\ConversationStatusEnum;
use App\Enums\GroupPrivilegeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConversationRequest extends FormRequest
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
            'group_id' => ['required', Rule::exists('groups', 'id')],
        ];
    }

    public function validated($key = null, $default = null)
    {
        return [
            'user_id' => $this->user()->id,
            'group_id' => $this->group_id,
            'group_privilege' => GroupPrivilegeEnum::MEMBER(),
            'is_mute'=>0,
            'is_favorite'=>0,
            'rate'=>0,
            'status'=>ConversationStatusEnum::ACTIVE(),
        ];
    }
}
