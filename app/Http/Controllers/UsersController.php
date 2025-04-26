<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\{
    StoreUserRequest,
    UpdateUserRequest,
    DeleteUserRequest
};
use App\Models\User;
use App\Traits\Images;

class UsersController extends Controller
{
    use Images;
    // Add admin middleware to deny the regular users to excute the all function except destroy.
    public function __construct()
    {
        $this->middleware('admin')->except('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(1, '', User::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Receive data, then process and move the image.
        $data = $request->except('image');
        $data['image'] = $this->moveImage($request->file('image'), 'users');

        $user = User::create($data);
        $user->forceFill([
            'is_admin' => $request->is_admin
        ])->save();
        return $this->generalResponse(1, 'User Added Successfully', $user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->generalResponse(1, '', $user->load(['posts', 'comments']), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->except('image');

        // Check if the image is found.
        if($request->has('image')) {
            // Move a new image.
            $data['image'] = $this->moveImage($request->file('image'), 'users');
            // Delete the old image.
            $this->deleteImage(public_path('users/') . $user->image);
        }

        $user->update($data);

        // Check if the role is updated or not.
        if($request->has('is_admin')) {
            $user->forceFill([
                'is_admin' => $request->is_admin
            ])->save();
        }

        return $this->generalResponse(1, 'User Updated Successfully', $user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        $this->deleteImage(public_path('users/') . $user->image);
        $user->delete();
        return $this->generalResponse(1, 'User Deleted Successfully', null, 200);
    }
}
