<?php

namespace App\Listeners;

use App\Services\OpenAIService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AutoReplyToComment
{
    /**
     * Create the event listener.
     */
    public function __construct(protected OpenAIService $openAIService) {}

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // Generate a reply based on the comment content
        $reply = $this->openAIService->generateReply($event->comment->content);

        // Update Comment Reply.
        $event->comment->update([
            'reply' => $reply,
        ]);
    }
}
