<?php

namespace App\Http\Controllers;

use App\Models\NicknameHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Mostrar el perfil del usuario autenticado.
     */
    public function edit()
{
    $user = Auth::user();

    /*
     * Autorizar que el usuario únicamente
     * pueda acceder a su propio perfil.
     */
    $this->authorize('update', $user);

    return view('profile.edit', compact('user'));
}

    /* Actualizar los datos del perfil.*/
    public function update(Request $request)
    {
        $user = Auth::user();

        /* Autorizar que el usuario únicamente pueda, modificar su propia cuenta. */
    $this->authorize('update', $user);

        /* Verificar si el usuario ya modificó su perfil, durante los últimos 2 meses. */
$lastProfileUpdate = \App\Models\AuditLog::where('action', 'update_profile')
    ->where('performed_by', $user->uuid)
    ->latest('created_at')
    ->first();

if ($lastProfileUpdate) {
    $nextAllowedDate = $lastProfileUpdate->created_at->copy()->addMonths(2);

    if (now()->lt($nextAllowedDate)) {
        return redirect()
            ->route('profile.edit')
            ->with(
                'error',
                'Solo puedes modificar tus datos una vez cada 2 meses. Podrás realizar otro cambio después del ' .
                $nextAllowedDate->format('d/m/Y')
            );
    }
}

    $validated = $request->validate([
    'first_name' => ['required', 'string', 'max:100'],
    'last_name' => ['required', 'string', 'max:100'],
    'email' => [
        'required',
        'email',
        'max:150',
        Rule::unique('users', 'email')->ignore($user->uuid, 'uuid'),
    ],
    'phone' => ['nullable', 'string', 'max:20'],
    'anonymous_nickname' => [
        'required',
        'string',
        'max:80',
        Rule::unique('users', 'anonymous_nickname')->ignore($user->uuid, 'uuid'),
    ],
]);

    /*
     * Guardar los datos anteriores para detectar cambios.
     */
    $oldData = [
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
    'email' => $user->email,
    'phone' => $user->phone,
    'anonymous_nickname' => $user->anonymous_nickname,
];

    /*
     * Comprobar si el nickname realmente cambió.
     */
    $nicknameChanged =
        $user->anonymous_nickname !== $validated['anonymous_nickname'];

    /*
     * Guardar el historial específico del nickname.
     */
    if ($nicknameChanged) {
        NicknameHistory::create([
            'user_uuid' => $user->uuid,
            'old_nickname' => $user->anonymous_nickname,
            'new_nickname' => $validated['anonymous_nickname'],
            'changed_at' => now(),
        ]);
    }

    /*
     * Actualizar datos del usuario.
     */
    $user->first_name = $validated['first_name'];
$user->last_name = $validated['last_name'];
$user->email = $validated['email'];
$user->phone = $validated['phone'];
$user->anonymous_nickname = $validated['anonymous_nickname'];

    $user->save();

    /*
     * Detectar y registrar únicamente los campos que realmente cambiaron.
     */
    $newData = [
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
    'email' => $user->email,
    'phone' => $user->phone,
    'anonymous_nickname' => $user->anonymous_nickname,
];

    $changes = [];

    foreach ($oldData as $field => $oldValue) {
        if ($oldValue != $newData[$field]) {
            $changes[$field] = 'MODIFICADO';
        }
    }

    /*
     * Registrar la modificación en auditoría solamente
     * si realmente hubo cambios.
     */
    if (!empty($changes)) {
        \App\Models\AuditLog::create([
            'action' => 'update_profile',
            'performed_by' => $user->uuid,
            'target_type' => 'User',
            'target_id' => $user->uuid,
            'changes' => $changes,
        ]);
    }

    return redirect()
        ->route('profile.edit')
        ->with('success', 'Tu perfil se actualizó correctamente.');
}

    /**
     * Actualizar la contraseña.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        $user->password_hash = Hash::make($request->password);

        $user->save();

        \App\Models\AuditLog::create([
            'action' => 'update_password',
            'performed_by' => $user->uuid,
            'target_type' => 'User',
            'target_id' => $user->uuid,
            'changes' => [
                'password' => 'MODIFICADA',
            ],
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('password_success', 'Tu contraseña se actualizó correctamente.');
    }
}
