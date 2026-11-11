<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EvaluationPublished implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $uuid,
        public string $title
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('evaluations'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'evaluation.published';
    }

    public function broadcastWith(): array
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
        ];
    }
}