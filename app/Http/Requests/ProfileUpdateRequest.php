<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:new_password', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Текущий пароль указан неверно.');
                }
            }],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Поле "Имя" обязательно для заполнения.',
            'last_name.required' => 'Поле "Фамилия" обязательно для заполнения.',
            'login.required' => 'Поле "Логин" обязательно для заполнения.',
            'login.unique' => 'Такой логин уже используется.',
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Введите корректный email адрес.',
            'email.unique' => 'Такой email уже используется.',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения.',
            'new_password.min' => 'Пароль должен содержать не менее 8 символов.',
            'new_password.confirmed' => 'Пароли не совпадают.',
        ];
    }
}