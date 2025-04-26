<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\{
    DeletePostRequest,
    StorePostRequest,
    UpdatePostRequest
};
use App\Events\PostCreated;
use App\Models\Post;
use App\Traits\Images;

class PostsController extends Controller
{
    use Images;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(1, '', Post::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // Check if the image is found.
        $data = $request->except('image');
        $data['user_id'] = $request->user()->id;
        if($request->has('image')) {
            $data['image'] = $this->moveImage($request->file('image'), 'posts');
        }
        $post = Post::create($data);

        // Post Created Event
        event(new PostCreated($post));
        return $this->generalResponse(1, 'Post Created Successfully, Please wait for admin approval.', null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->generalResponse(1, '', $post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->except('image');

        // Check if the image is found.
        if($request->has('image')) {
            // Move a new image.
            $data['image'] = $this->moveImage($request->file('image'), 'posts');
            // Delete the old image.
            $this->deleteImage(public_path('posts/') . $post->image);
        }

        // Update the post.
        $post->update($data);
        return $this->generalResponse(1, 'Post Updated Successfully', $post, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeletePostRequest $request, Post $post)
    {
        $post->delete();
        return $this->generalResponse(1, 'Post Deleted Successfully', null, 200);
    }
}
