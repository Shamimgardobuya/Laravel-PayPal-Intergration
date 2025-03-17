<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class StaffFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     // if (request('role') == 'Super Admin' ){
    //     //     return true;
    //     // }
    //     // else {
    //     //     return false;

    //     // }
    //     re
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'=> 'required|string|max:25',
            'last_name'=> 'required|string|max:25',
            'role'=> 'required|string|max:25',
            'email'=> 'sometimes|email|unique:staff',
            'phone'=> 'sometimes|string|unique:staff',
            'file' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:20248'
        ];
    }

    public function messages() : array
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'role.required' => 'Role is required',
            'email.email' => 'Email is not valid',
            'email.unique' => 'Email is already taken',
            'phone.unique' => 'Phone number is already taken',
            'file.image' => 'File should be of type image'
        ];
    }
}
