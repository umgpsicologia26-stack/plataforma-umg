<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Canal privado de notificaciones de moderadores
|--------------------------------------------------------------------------
| Cada moderador solo puede escuchar las notificaciones dirigidas
| a su propio UUID.
*/

Broadcast::channel('moderator.{moderatorUuid}', function (
    User $user,
    string $moderatorUuid
): bool {
    return strtoupper($user->role) === 'MODERATOR'
        && hash_equals((string) $user->uuid, $moderatorUuid);
});

/*
|--------------------------------------------------------------------------
| Canal privado de notificaciones personales
|--------------------------------------------------------------------------
| Cada usuario autenticado solo puede escuchar su propio canal.
*/

Broadcast::channel('user.{userUuid}', function (
    User $user,
    string $userUuid
): bool {
    return hash_equals((string) $user->uuid, $userUuid);
});

/*
|--------------------------------------------------------------------------
| Canal del foro
|--------------------------------------------------------------------------
| Todas las personas autenticadas pueden escuchar las publicaciones
| del foro. No se limita el acceso al rol MODERATOR.
*/

Broadcast::channel('forum', function (User $user): bool {
    return !empty($user->uuid);
});

/*
|--------------------------------------------------------------------------
| Canal general de administradores
|--------------------------------------------------------------------------
| Solo cuentas ADMIN. Por este canal viaja únicamente la señal
| "el caso X cambió" (sin texto de comentarios ni datos personales).
*/
Broadcast::channel('admins', function (User $user): bool {
    return strtoupper((string) $user->role) === 'ADMIN';
});

/*
|--------------------------------------------------------------------------
| Canal privado de UN administrador
|--------------------------------------------------------------------------
| Cada administrador solo escucha el contador de sus propias
| notificaciones (el estado de lectura es individual).
*/
Broadcast::channel('admin.{adminUuid}', function (
    User $user,
    string $adminUuid
): bool {
    return strtoupper((string) $user->role) === 'ADMIN'
        && hash_equals((string) $user->uuid, $adminUuid);
});