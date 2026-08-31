<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetCode;
use App\Mail\PasswordResetCodeMail;
use App\Models\User;
use App\Models\AuditLog;
use App\Models\NicknameHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    //LISTAR//
    public function index()
    {
        $this->checkRole(['ADMIN', 'MODERATOR']);

        $users = User::all();

        return view('admin.users', compact('users'));
    }

    //CREAR// 
    public function store(Request $request)
    {
        $this->checkRole(['ADMIN', 'MODERATOR']);

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        User::create([
            'uuid' => (string) Str::uuid(),
            'firebase_uid' => (string) Str::uuid(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'anonymous_nickname' => 'User' . rand(1000,9999),
            'password_hash' => bcrypt('12345678'),
            'role' => 'USER',
            'status' => 'ACTIVO'
        ]);

        return back()->with('success', 'Usuario creado');
    }

    //UPDATE// 
    public function update(Request $request, $id)
    {
        $this->checkRole(['ADMIN', 'MODERATOR']);

        $user = User::findOrFail($id);
        $oldData = $user->toArray();
        $oldNickname = $user->anonymous_nickname;

        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($user->uuid, 'uuid')
            ],
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'anonymous_nickname' => [
                'required',
                'string',
                'max:80',
                Rule::unique('users', 'anonymous_nickname')
                    ->ignore($user->uuid, 'uuid')
            ],
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'anonymous_nickname' => $request->anonymous_nickname,
            'role' => Auth::user()->role === 'ADMIN'
                ? ($request->role ?? $user->role)
                : $user->role,
        ]);

        if ($oldNickname !== $user->anonymous_nickname) {
            NicknameHistory::create([
                'uuid' => (string) Str::uuid(),
                'user_uuid' => $user->uuid,
                'old_nickname' => $oldNickname,
                'new_nickname' => $user->anonymous_nickname,
                'changed_at' => now(),
            ]);
        }

        AuditLog::create([
            'action' => 'update',
            'performed_by' => Auth::user()->uuid,
            'target_user' => $user->uuid,
            'changes' => json_encode([
                'before' => $oldData,
                'after' => $user->fresh()->toArray()
            ])
        ]);

        return back()->with('success', 'Usuario actualizado');
    }

    //DELETE// 
    public function destroy($id)
    {
        $this->checkRole(['ADMIN']);

        User::findOrFail($id)->delete();

        return back()->with('success', 'Usuario eliminado');
    }

    //ENVIAR CÓDIGO DE RECUPERACIÓN// 
public function sendResetCode(Request $request)
{
    $request->validate([
        'email' => 'required|email|max:150'
    ]);

    // Limita solicitudes de recuperación por IP + correo.
    $key = 'password-recovery:' .
        Str::lower($request->email) .
        '|' .
        $request->ip();

    if (RateLimiter::tooManyAttempts($key, 3)) {
        return back()->with(
            'error',
            'Demasiadas solicitudes. Intenta nuevamente en unos minutos.'
        );
    }

    RateLimiter::hit($key, 300);

    $user = User::where(
        'email',
        $request->email
    )->first();

    // No revela si el correo existe.
    if (!$user || $user->status !== 'ACTIVO') {
        return back()->with(
            'success',
            'Si existe una cuenta asociada al correo indicado, recibirás un código de recuperación.'
        );
    }

    DB::transaction(function () use ($user, $request) {

        // Elimina códigos anteriores que todavía no hayan sido utilizados.
        PasswordResetCode::where('user_uuid', $user->uuid)
            ->whereNull('used_at')
            ->delete();

        // Generar código aleatorio de 6 dígitos.
        $code = (string) random_int(100000, 999999);

        PasswordResetCode::create([
            'user_uuid' => $user->uuid,

            // El código nunca se almacena en texto plano.
            'code_hash' => Hash::make($code),

            // El código solamente será válido durante 3 minutos.
            'expires_at' => Carbon::now()->addMinutes(3),
        ]);

        // Enviar código por correo.
        Mail::to($user->email)->send(
            new PasswordResetCodeMail($code)
        );

        // Guardar información necesaria para continuar la recuperación.
        session([
            'reset_user_uuid' => $user->uuid,
            'reset_email_masked' => $this->maskEmail($user->email),
        ]);

        // Solo para entorno local de demostración.
        if (
            app()->environment('local') &&
            config('app.demo_recovery_code', false)
        ) {
            session([
                'demo_recovery_code' => $code
            ]);
        }
    });

    return redirect('/reset-password')
        ->with(
            'success',
            'Si existe una cuenta asociada al correo indicado, recibirás un código de recuperación.'
        );
}

    //CAMBIAR CONTRASEÑA//
public function resetPassword(Request $request)
{
    $request->validate([
        'code' => 'required|digits:6',

        'password' => [
            'required',
            'confirmed',
            'min:8'
        ]
    ]);

    $uuid = session('reset_user_uuid');

    if (!$uuid) {
        return redirect('/forgot-password')
            ->with(
                'error',
                'La sesión de recuperación expiró. Solicita un nuevo código.'
            );
    }

    $user = User::find($uuid);

    if (!$user || $user->status !== 'ACTIVO') {

        session()->forget([
            'reset_user_uuid',
            'reset_email_masked',
            'demo_recovery_code'
        ]);

        return redirect('/forgot-password')
            ->with(
                'error',
                'No fue posible completar la recuperación.'
            );
    }

    $reset = PasswordResetCode::where(
            'user_uuid',
            $user->uuid
        )
        ->whereNull('used_at')
        ->latest('id')
        ->first();

    // No existe código
    if (!$reset) {
        return redirect('/reset-password')
            ->with(
                'code_expired',
                'El código ha vencido. Solicita un nuevo código de recuperación.'
            );
    }

    // CÓDIGO VENCIDO//

    if (now()->greaterThanOrEqualTo($reset->expires_at)) {

    $reset->used_at = now();
    $reset->save();

    session()->forget([
        'reset_user_uuid',
        'reset_email_masked',
        'demo_recovery_code'
    ]);

    return redirect('/reset-password')
        ->with('code_expired', true);
}

    // CÓDIGO INCORRECTO// 
    if (!Hash::check($request->code, $reset->code_hash)) {

        return back()
            ->withInput()
            ->with(
                'error',
                'El código ingresado es incorrecto.'
            );
    }

    //CAMBIAR CONTRASEÑA//
    DB::transaction(function () use ($user, $reset, $request) {

        $user->password_hash = Hash::make(
            $request->password
        );

        $user->save();

        // Marcar código como utilizado
        $reset->used_at = now();
        $reset->save();
    });

    // Limpiar información de recuperación
    session()->forget([
        'reset_user_uuid',
        'reset_email_masked',
        'demo_recovery_code'
    ]);

    // Limpiar límite de recuperación
    RateLimiter::clear(
        'password-recovery:' .
        Str::lower($user->email) .
        '|' .
        $request->ip()
    );

    return redirect('/login')
        ->with(
            'success',
            'Contraseña actualizada correctamente. Ya puedes iniciar sesión.'
        );
}   

    //MOSTRAR CAMBIO DE CONTRASEÑA// 
public function showChangePassword()
{
    return view('auth.change-password');
}


    //CAMBIAR CONTRASEÑA//
public function changePassword(Request $request)
{
    $request->validate([
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed'
        ],
    ]);

    $user = Auth::user();

    $user->password_hash = Hash::make(
        $request->password
    );

    $user->must_change_password = false;

    $user->save();

    return redirect('/dashboard')
        ->with(
            'success',
            'Contraseña actualizada correctamente.'
        );
}

    //Ocultar correo electrónico
    private function maskEmail($email)
    {
    $parts = explode('@', $email);

    if (count($parts) !== 2) {
        return $email;
    }

    $name = $parts[0];
    $domain = $parts[1];

    if (strlen($name) <= 2) {
        $maskedName = substr($name, 0, 1) . '***';
    } 
    else 
        {
        $maskedName =
            substr($name, 0, 2)
            . str_repeat('*', max(4, strlen($name) - 2));
    }

        return $maskedName . '@' . $domain;
    }
}
