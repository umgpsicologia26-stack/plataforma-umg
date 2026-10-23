<?php

namespace App\Events;

use App\Models\AdminNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\DB;

/**
 * Se emite al canal privado de UN administrador cuando se crea o se lee
 * una de sus notificaciones. Solo lleva el contador de no leídas de ese
 * administrador; el detalle se obtiene con una petición autenticada.
 */
class AdminNotificationsChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public function __construct(
        public string $adminUuid,
        public string $reason = 'created'
    ) {
    }

    /**
     * Emite después de confirmar la transacción abierta (si la hay) y
     * nunca rompe la petición si Reverb no está disponible.
     */
    public static function emit(
        string $adminUuid,
        string $reason = 'created'
    ): void {
        DB::afterCommit(function () use ($adminUuid, $reason) {
            try {
                event(new static($adminUuid, $reason));
            } catch (\Throwable $e) {
                report($e);
            }
        });
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin.' . $this->adminUuid),
        ];
    }

    public function broadcastAs(): string
    {
        return 'admin.notifications.changed';
    }

    public function broadcastWith(): array
    {
        return [
            'reason' => $this->reason,
            'unread_count' => AdminNotification::unreadCountFor(
                $this->adminUuid
            ),
        ];
    }
}
