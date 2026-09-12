<?php

namespace App\Policies;

use App\Models\CaseFile;
use App\Models\User;

class CaseFilePolicy
{
    /**
     * Determina si el usuario puede ver algún caso.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            'USER',
            'MODERATOR',
            'ADMIN',
        ]);
    }

    /**
     * Determina si el usuario puede ver un caso específico.
     */
    public function view(User $user, CaseFile $caseFile): bool
    {
        if ($user->role === 'ADMIN') {
            return true;
        }

        if ($user->role === 'MODERATOR') {
            return $caseFile->moderator_uuid === $user->uuid;
        }

        if ($user->role === 'USER') {
            return $caseFile->user_uuid === $user->uuid;
        }

        return false;
    }

    /**
     * Determina si el usuario puede crear casos.
     */
    public function create(User $user): bool
    {
        return $user->role === 'USER';
    }

    /**
     * Determina si el usuario puede actualizar un caso.
     */
    public function update(User $user, CaseFile $caseFile): bool
    {
        if ($user->role === 'ADMIN') {
            return true;
        }

        if ($user->role === 'MODERATOR') {
            return $caseFile->moderator_uuid === $user->uuid;
        }

        return false;
    }

    /**
     * Determina si el usuario puede eliminar un caso.
     */
    public function delete(User $user, CaseFile $caseFile): bool
    {
        return $user->role === 'ADMIN';
    }

    /**
     * Determina si el usuario puede restaurar un caso.
     */
    public function restore(User $user, CaseFile $caseFile): bool
    {
        return $user->role === 'ADMIN';
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un caso.
     */
    public function forceDelete(User $user, CaseFile $caseFile): bool
    {
        return $user->role === 'ADMIN';
    }
}