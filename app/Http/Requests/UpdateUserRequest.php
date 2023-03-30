<?php

namespace App\Http\Requests;

use App\Enums\ColorThemeEnum;
use App\Models\Interesting;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Enum\Laravel\Rules\EnumRule;

class UpdateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'about' => ['nullable', 'string'],
            'mobile_phone' => ['nullable', 'string'],
            'theme_color' => ['nullable', new EnumRule(ColorThemeEnum::class)],
            'interesting' => ['nullable', 'array'],
            'interesting.*' => ['required', Rule::exists('interestings', 'id')]
        ];

    }

    public function validated($key = null, $default = null)
    {
        $this->theme_color ??= ColorThemeEnum::WHITE();

        return [
            'user_profile' => [
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "about" => $this->about,
                "mobile_phone" => $this->mobile_phone,
                "theme_color" => $this->theme_color,
            ],
            "image" => $this->image,
            "interesting" => $this->interesting,
        ];
    }
}
