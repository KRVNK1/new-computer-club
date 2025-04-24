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
            'email' => ['required', 'string', 'email', 'email:rfc,dns', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:11', 'min:11'],
            'current_password' => ['nullable', 'required_with:new_password', function ($value, $fail) use ($user) {
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
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Введите корректный email адрес.',
            'email.rfc,dns' => 'Введите корректный домена email.',
            'email.unique' => 'Такой email уже используется.',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения.',
            'phone.min' => 'Поле "Телефон" должно содержать 11 символов.',
            'phone.max' => 'Поле "Телефон" должно содержать 11 символов.',
        ];
    }
}