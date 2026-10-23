<?php

namespace App\Events;

use App\Models\ForumMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ForumPostCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public ForumMessage $message
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('forum'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'forum.post.created';
    }

    public function broadcastWith(): array
    {
        $this->message->loadMissing('user');

        $user = $this->message->user;

        return [
            'uuid' => $this->message->uuid,
            'content' => $this->message->content,
            'category' => $this->message->category,
            'is_anonymous' => (bool) $this->message->is_anonymous,
            'display_name' => $this->message->is_anonymous
                ? ($user?->anonymous_nickname ?? 'Usuario Anónimo')
                : ($user?->full_name ?? 'Usuario'),
            'created_at' => $this->message->created_at
                ->format('d/m/Y H:i'),
            'visibility_status' => $this->message->visibility_status,
        ];
    }
}
