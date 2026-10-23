<?php

namespace App\Models;

use App\Events\AdminNotificationsChanged;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class AdminNotification extends Model
{
    protected $fillable = [
        'case_id',
        'user_uuid',
        'message',
        'read'
    ];

    protected $casts = [
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Caché de existencia de columnas para no consultar el esquema
     * más de una vez por petición.
     */
    protected static array $columnCache = [];

    public function caseFile()
    {
        return $this->belongsTo(
            CaseFile::class,
            'case_id',
            'id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
            'uuid'
        );
    }

    /**
     * Indica si la tabla tiene una columna concreta.
     */
    protected static function hasColumn(string $column): bool
    {
        $table = (new static())->getTable();

        return static::$columnCache[$table . '.' . $column]
            ??= Schema::hasColumn($table, $column);
    }

    /**
     * ¿La notificación ya fue leída?
     * Funciona con la columna `read` y/o con `read_at`, según
     * la que exista realmente en la tabla.
     */
    public function isRead(): bool
    {
        $attributes = $this->getAttributes();

        return ($attributes['read_at'] ?? null) !== null
            || (bool) ($attributes['read'] ?? false);
    }

    /**
     * Marca la notificación como leída y la guarda en la base de datos.
     */
    public function markAsRead(): void
    {
        if ($this->isRead()) {
            return;
        }

        $attributes = $this->getAttributes();

        $hasReadAt = array_key_exists('read_at', $attributes);
        $hasRead = array_key_exists('read', $attributes);

        if (!$hasReadAt && !$hasRead) {
            throw new \RuntimeException(
                'La tabla admin_notifications no tiene columna read ni read_at.'
            );
        }

        if ($hasReadAt) {
            $this->read_at = now();
        }

        if ($hasRead) {
            $this->read = true;
        }

        $this->save();
    }

    /**
     * Notificaciones no leídas.
     */
    public function scopeUnread(Builder $query): Builder
    {
        if (static::hasColumn('read_at')) {
            $query->whereNull('read_at');
        }

        if (static::hasColumn('read')) {
            $query->where('read', false);
        }

        return $query;
    }

    /**
     * Notificaciones no leídas de UN administrador.
     * Misma regla que usa la sección de notificaciones, para que el panel
     * y la lista nunca muestren contadores distintos.
     */
    public static function unreadCountFor(string $adminUuid): int
    {
        return static::query()
            ->unread()
            ->where('user_uuid', $adminUuid)
            ->count();
    }

    /**
     * Crea una notificación de administrador asociada a un caso.
     * Evita duplicados: si ya existe una idéntica creada en los
     * últimos 10 segundos (doble clic, reenvío), se reutiliza.
     */
    public static function notifyCase(
        CaseFile $case,
        string $message,
        string $userUuid,
        bool $dedupe = true
    ): self {
        if ($dedupe) {
            $existing = static::query()
                ->where('case_id', $case->id)
                ->where('user_uuid', $userUuid)
                ->where('message', $message)
                ->where('created_at', '>=', now()->subSeconds(10))
                ->first();

            if ($existing) {
                return $existing;
            }
        }

        return static::create([
            'case_id' => $case->id,
            'user_uuid' => $userUuid,
            'message' => $message,
            'read' => false,
        ]);
    }

    /**
     * Crea UNA notificación por cada administrador activo (cada uno con su
     * propio estado de lectura) y avisa en tiempo real a cada uno de ellos.
     */
    public static function notifyAdmins(
        CaseFile $case,
        string $message,
        bool $dedupe = true
    ): void {
        $adminUuids = User::query()
            ->where('role', 'ADMIN')
            ->where('status', 'Activo')
            ->pluck('uuid');

        foreach ($adminUuids as $adminUuid) {
            $notification = static::notifyCase(
                $case,
                $message,
                (string) $adminUuid,
                $dedupe
            );

            // Solo se avisa cuando la fila es realmente nueva.
            if ($notification->wasRecentlyCreated) {
                AdminNotificationsChanged::emit((string) $adminUuid, 'created');
            }
        }
    }
}
