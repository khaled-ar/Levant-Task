<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class DeletePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = request()->user();
        if($user->is_admin) {
            return true;
        }
        // Get the post's ids for the user and then check if the requested post's id in the array.
        $user_posts = $user->posts()->without('comments')->pluck('id')->toArray();
        return in_array(request()->post->id, $user_posts);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
