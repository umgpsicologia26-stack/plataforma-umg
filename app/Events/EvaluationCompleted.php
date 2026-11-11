<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EvaluationCompleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $notificationId,
        public string $moderatorUuid,
        public string $message,
        public string $createdAt
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('moderator.' . $this->moderatorUuid),
        ];
    }

    public function broadcastAs(): string
    {
        return 'evaluation.completed';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->notificationId,
            'message' => $this->message,
            'created_at' => $this->createdAt,
        ];
    }
}