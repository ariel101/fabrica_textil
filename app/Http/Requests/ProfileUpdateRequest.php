<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                'max:50',
                Rule::unique('users', 'username')->ignore($this->user()->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            'cellphone' => [
                'required',
                'string',
                'regex:/^[0-9]{8,20}$/',
                Rule::unique('users', 'cellphone')->ignore($this->user()->id),
            ],

            'identity_card' => [
                'required',
                'string',
                'regex:/^[0-9]{7,20}$/',
                Rule::unique('users', 'identity_card')->ignore($this->user()->id),
            ],

            'city' => [
                'required',
                'string',
                Rule::in([
                    'La Paz',
                    'El Alto',
                    'Cochabamba',
                    'Santa Cruz',
                    'Sucre',
                    'Oruro',
                    'Potosi',
                    'Tarija',
                    'Beni',
                    'Pando',
                ]),
            ],

        ];
    }
}
