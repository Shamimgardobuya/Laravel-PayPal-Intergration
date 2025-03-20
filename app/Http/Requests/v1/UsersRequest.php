<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:20',
            'email' => 'required|email',
            'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{9,}$/',
            'user_role' => 'required|in:Super Admin,Staff'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Maximum number of characters is 20',
            'email.required' => 'Email is required',
            'email.email' => 'Email has to be a valid email', 
            'password.min' => 'Password has to be minimum of 9 characters',
            'password.regex' => [
            ' At least one uppercase English letter',
            'At least one lowercase English letter',
            'At least one digit.',
            'At least one special character'
            ]
            ];
    }
}
