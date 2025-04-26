<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\{
    LoginRequest,
    RegisterRequest
};
use App\Models\User;
use App\Traits\Images;

class AuthController extends Controller
{
    use Images;

    public function register(RegisterRequest $request) {
        // Receive data, then process and move the image.
        $data = $request->except('image');
        $data['image'] = $this->moveImage($request->file('image'), 'posts');
        // Create the user and return the response.
        $user = User::create($data);
        // Note: We can notify the user with verfication code here or using event created in user model.
        return $this->generalResponse(1, 'Account Created Successfully', $user, 201);
    }

    public function login(LoginRequest $request) {
        // Check user credentials if invalid.
        if(!$request->authenticate()) {
            return $this->generalResponse(0, 'Invalid Credentials.', null, 401);
        }

        // Valid credentials case.
        $user = User::whereEmail($request->email)->first();
        $user['token'] = $user->createToken($user->name)->plainTextToken;
        return $this->generalResponse(1, 'Login Done Successfully.', $user, 200);
    }
}
