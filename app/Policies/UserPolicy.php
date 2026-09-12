<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determinar si el usuario puede actualizar un usuario.
     *
     * Cada usuario únicamente puede modificar
     * sus propios datos de perfil.
     */
    public function update(User $user, User $targetUser): bool
    {
        return $user->uuid === $targetUser->uuid;
    }
}