<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['string', 'between:3,15'],
            'email' => ['email', 'unique:users,email,' . request()->user->id . ',id'],
            'image' => ['file', 'mimes:png,jpg', 'max:2048'],
            'is_admin' => ['boolean'],
        ];
    }
}
