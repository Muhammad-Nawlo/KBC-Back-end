<?php

namespace App\Http\Requests;

use App\Enums\GroupTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;

class GroupRequest extends FormRequest
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
        $uniqueTitle = Rule::unique('groups', 'title');
        $uniqueGroupName = Rule::unique('groups', 'group_name');
        if (request()->method === 'put') {
            $uniqueTitle->ignore($this->group);
            $uniqueGroupName->ignore($this->group);
        }
        return [
            "title" => ['required', 'string', 'max:255', $uniqueTitle],
            "group_name" => ['required', 'string', 'max:255', $uniqueGroupName],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif'],
            'about' => ['nullable', 'string'],
            'max_member' => ['nullable', 'numeric'],
            'interesting' => [Rule::requiredIf(fn() => request()->isMethod('POST')), 'array'],
            'interesting.*' => [Rule::requiredIf(fn() => $this->interesting !== null), Rule::exists('interestings', 'id')],
            'group_type_id' => ['required', Rule::exists('group_types', 'id')],
            'user_can_join_directly' => ['required', 'boolean']
        ];
    }

    public function validated($key = null, $default = null)
    {
        return [
            "title" => $this->title,
            "group_name" => $this->group_name,
            'image' => $this->image,
            'about' => $this->about,
            'max_member' => $this->max_member ?? 50,
            'interesting' => $this->interesting,
            'group_type_id' => $this->group_type_id,
            'user_can_join_directly' => $this->user_can_join_directly,
        ];
    }
}
