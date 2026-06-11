<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:100'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'nickname'          => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9_]+$/', 'unique:users,nickname'],
            'x_account'         => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9_]+$/', 'unique:users,x_account'],
            'location_id'       => ['required', 'integer', 'exists:cities,id'],
            'supported_team_id' => ['required', 'integer', 'exists:world_cup_teams,id'],
            'password'          => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'             => 'Nama wajib diisi.',
            'name.max'                  => 'Nama maksimal 100 karakter.',
            'nickname.regex'            => 'Nickname hanya boleh berisi huruf, angka, dan underscore.',
            'nickname.unique'           => 'Nickname sudah digunakan.',
            'nickname.max'              => 'Nickname maksimal 30 karakter.',
            'x_account.regex'           => 'Akun X hanya boleh berisi huruf, angka, dan underscore.',
            'x_account.unique'          => 'Akun X sudah digunakan.',
            'x_account.max'             => 'Akun X maksimal 50 karakter.',
            'email.unique'              => 'Email sudah terdaftar.',
            'location_id.exists'        => 'Kota tidak ditemukan.',
            'supported_team_id.exists'  => 'Tim tidak ditemukan.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nickname'  => strtolower(trim($this->nickname ?? '')),
            'x_account' => strtolower(trim($this->x_account ?? '')),
        ]);
    }
}
