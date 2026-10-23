<?php

namespace App\Events;

use App\Models\ModeratorNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ForumNotificationCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public ModeratorNotification $notification
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                'moderator.' . $this->notification->moderator_uuid
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'forum.notification.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification->id,
            'message' => $this->notification->message,
            'created_at' => $this->notification->created_at
                ? $this->notification->created_at->format('d/m/Y H:i')
                : now()->format('d/m/Y H:i'),
        ];
    }
}
