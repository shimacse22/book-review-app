<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required| min:5|max:125',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:5|max:25',
            
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'=>'Please enter your name',
            'name.min'=>'Name must be at least 5 chars long',
            'name.max'=>'Name must not be more than 125 chars',
            'email.required'=>'Please enter your email',
            'email.email'=>'email must be a valid email address',
            'name.unique'=>'the email has already been taken',
            'password.required'=>'Please enter your password',
            'password.min'=>'Password must be at least 5 chars long',
            'password.max'=>'Password must not be more than 25 chars',

        ];
    }
}
