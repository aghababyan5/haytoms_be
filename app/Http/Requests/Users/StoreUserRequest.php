<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                  => [
                'required',
                'regex:/^[a-zA-Z1-9_ ]+$/u',
                'min:3',
                'max:100',
            ], // kara ylni mecatar poqratar u tver
            'surname'               => [
                'nullable',
                'regex:/^[a-zA-Z ]+$/u',
                'min:3',
                'max:100',
            ], // kara ylni mecatar poqratar u tver
            'username'              => [
                'required',
                'email',
                'unique:users,email',
            ],
            'phone_number'          => [
                'required',
                'string',
                'regex:/^[0-9]{7,20}$/',
            ], // Menak tver, 7ic 20 simvol
            'password'              => [
                'required',
                'string',
                'min:8',
                'regex:/[0-9]/',
            ], // minimumy 8 simvol partadir 1 hat tvov
            // Amenaqichy 1 tiv
            'password_confirmation' => ['required', 'same:password'],
            'role'                  => ['required', 'string'],
        ];
    }
}
