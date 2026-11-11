<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ChatMessageCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $moderatorUuid
    ) {
    }

    public static function emit(string $moderatorUuid): void
    {
        if ($moderatorUuid === '') {
            return;
        }

        DB::afterCommit(function () use ($moderatorUuid) {
            try {
                event(new static($moderatorUuid));
            } catch (\Throwable $e) {
                report($e);
            }
        });
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('moderator.' . $this->moderatorUuid),
        ];
    }

    public function broadcastAs(): string
    {
        return 'chat.message.created';
    }

    public function broadcastWith(): array
    {
        return [];
    }
}
