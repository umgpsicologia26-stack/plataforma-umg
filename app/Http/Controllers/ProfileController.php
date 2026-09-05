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

        return view('profile.edit', compact('user'));
    }

    /**
     * Actualizar los datos del perfil.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'anonymous_nickname' => [
                'required',
                'string',
                'max:80',
                Rule::unique('users', 'anonymous_nickname')->ignore($user->uuid, 'uuid'),
            ],
        ]);

        /*
         * Comprobar si el nickname realmente cambió.
         */
        $nicknameChanged =
            $user->anonymous_nickname !== $validated['anonymous_nickname'];

        /*
         * Guardar el historial antes de actualizar el usuario.
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
        $user->phone = $validated['phone'];
        $user->anonymous_nickname = $validated['anonymous_nickname'];

        $user->save();

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

        return redirect()
            ->route('profile.edit')
            ->with('password_success', 'Tu contraseña se actualizó correctamente.');
    }
}