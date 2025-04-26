<?php

namespace App\Jobs;

use App\Models\{
    Post,
    User
};
use App\Notifications\PostCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class PostCreatedProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Post $post) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Load post's owner
        $this->post->load('user');

        // Create costum message.
        $message = "Post id: {$this->post->id}, User id: {$this->post->user->id}, User name: {$this->post->user->name}\n";
        $title = "Post title: {$this->post->title}";

        // Get the admins and notify them.
        $admins = User::where('is_admin', 1)->get();
        Notification::send($admins, new PostCreatedNotification($message, $title));
    }
}
