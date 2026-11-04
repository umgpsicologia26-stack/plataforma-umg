<?php

namespace App\Events;

use App\Models\AdminNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\DB;

class UserRegistered implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public function __construct(
        public string $userUuid
    ) {}

    public static function emit(string $userUuid): void
    {
        DB::afterCommit(function () use ($userUuid) {
            try {
                event(new static($userUuid));
            } catch (\Throwable $e) {
                report($e);
            }
        });
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admins'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'admin.user.registered';
    }

    public function broadcastWith(): array
    {
        return [
            'user_uuid' => $this->userUuid,
        ];
    }
}