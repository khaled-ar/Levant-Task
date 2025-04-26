<?php

namespace App\Listeners;

use App\Jobs\PostCreatedProcess;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostCreatedEmailNotification
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        PostCreatedProcess::dispatch($event->post);
    }
}
