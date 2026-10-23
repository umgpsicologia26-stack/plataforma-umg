<?php

namespace App\Events;

use App\Models\CaseComment;
use App\Models\CaseFile;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

/**
 * Señal de "algo cambió en este caso".
 *
 * El evento NO transporta texto de comentarios ni nombres: solo indica
 * qué caso cambió. Cada vista vuelve a pedir su propia página por HTTP
 * autenticado, de modo que el servidor sigue aplicando permisos, filtros
 * de privacidad y cifrado.
 *
 * Tipos: case.created | case.comment.created | case.status.updated
 */
class CaseActivityUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public CaseFile $case,
        public ?CaseComment $comment,
        public string $activityType
    ) {
        $this->comment?->loadMissing('user');
    }

    /**
     * Emite el evento DESPUÉS de confirmar la transacción abierta (si la hay)
     * y nunca rompe la petición si Reverb no está disponible.
     */
    public static function emit(
        CaseFile $case,
        ?CaseComment $comment,
        string $activityType
    ): void {
        DB::afterCommit(function () use ($case, $comment, $activityType) {
            try {
                event(new static($case, $comment, $activityType));
            } catch (\Throwable $e) {
                report($e);
            }
        });
    }

    public function broadcastOn(): array
    {
        // Administradores: solo reciben la señal (sin contenido).
        $channels = [
            new PrivateChannel('admins'),
        ];

        // Solo el moderador asignado al caso.
        if ($this->case->moderator_uuid) {
            $channels[] = new PrivateChannel(
                'moderator.' . $this->case->moderator_uuid
            );
        }

        // El dueño del caso, salvo en la creación y salvo observaciones
        // del administrador (visibles solo para el moderador).
        if (
            $this->activityType !== 'case.created' &&
            $this->authorRole() !== 'ADMIN'
        ) {
            $channels[] = new PrivateChannel(
                'user.' . $this->case->user_uuid
            );
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'case.activity.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'activity_type' => $this->activityType,
            'case_id' => (string) $this->case->id,
            'case_number' => $this->case->case_number,
            'case_status' => $this->case->status,
            'comment_id' => $this->comment
                ? (string) $this->comment->id
                : null,
            'comment_type' => $this->comment?->type,
        ];
    }

    private function authorRole(): string
    {
        return strtoupper((string) ($this->comment?->user?->role ?? ''));
    }
}