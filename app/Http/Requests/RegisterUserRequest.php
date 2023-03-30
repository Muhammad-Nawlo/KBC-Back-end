<?php

namespace App\Http\Requests;

use App\Enums\ColorThemeEnum;
use App\Enums\UserStatusEnum;
use App\Models\Interesting;
use App\Models\User;
use App\Models\UserProfile;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Enum\Laravel\Rules\EnumRule;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => [Rule::requiredIf(fn() => +$this->register_using_email === 1),
                'email',
                'max:255',
                Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', Password::default()],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif'],
            'user_name' => ['required', 'string', 'max:255', Rule::unique('users', 'user_name')],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'about' => ['nullable', 'string'],
            'mobile_phone' => [Rule::requiredIf(fn() => +$this->register_using_email === 0),
                'string', Rule::unique('user_profiles', 'mobile_phone'),
                new PhoneNumber()],
            'theme_color' => ['nullable', new EnumRule(ColorThemeEnum::class)],
            'interesting' => ['nullable', 'array'],
            'interesting.*' => [Rule::requiredIf(fn() => $this->interesting !== null), Rule::exists('interestings', 'id')],
            'register_using_email' => ['required', Rule::in([0, 1])]
        ];
    }

    public function validated($key = null, $default = null)
    {
        if ($this->theme_color === null) {
            $this->theme_color = ColorThemeEnum::WHITE();
        }
        return [
            'user' => [
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'status' => UserStatusEnum::ACTIVE(),
                'user_name' => $this->user_name,
            ],
            'user_profile' => [
                'image' => $this->image,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'about' => $this->about,
                'mobile_phone' => $this->mobile_phone,
                'theme_color' => $this->theme_color,
                'interesting' => $this->interesting,
            ],
        ];


    }
}
