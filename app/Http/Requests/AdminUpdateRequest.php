<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
        $isEmailExist = User::where('email', $this->email)->exists();

        $rules = [
            'fullname' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s]*$/'],
        ];

        if ($this->email && !$isEmailExist) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'min:4', 'unique:users,email'];
        }

        if ($this->password) {
            $rules['password'] = ['required', 'string', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'];
        }

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return [
            'fullname.regex' => 'The name field must be alphabet.',
            'password.regex' => 'The password field must be at least 8 characters, one uppercase, one lowercase, one number, and one special character.',
            'email.unique' => 'The email is already taken.',
            'email.regex' => 'The email field must be a valid email.',
        ];
    }
}
