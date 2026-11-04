<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\UserRegistered;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class AuthController extends Controller
{
    // MOSTRAR LOGIN
    public function showLogin()
    {
        return view('auth.login');
    }

    // REGISTRO PÚBLICO
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:150'
            ],
            'last_name' => [
                'required',
                'string',
                'max:100'
            ],
            'anonymous_nickname' => [
                'required',
                'string',
                'max:80',
                'unique:users,anonymous_nickname'
            ],
            'birth_date' => [
                'required',
                'date'
            ],
            'phone' => [
                'required',
                'string',
                'max:20'
            ],
            'email' => [
                'required',
                'email',
                'max:150',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:8'
            ],
        ]);

        $user = User::create([
            /*
             * UUID principal del usuario
             */
            'uuid' => (string) Str::uuid(),

            /*
             * Identificador interno.
             * Actualmente no se está utilizando Firebase
             * para el registro mediante correo.
             */
            'firebase_uid' => (string) Str::uuid(),

            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'email' => $request->email,

            'anonymous_nickname' =>
                $request->anonymous_nickname,

            'provider' => 'EMAIL',

            /*
             * La contraseña SIEMPRE se guarda cifrada.
             */
            'password_hash' =>
                Hash::make($request->password),

            'phone' => $request->phone,

            /*
             * Todo usuario que se registra públicamente
             * comienza como USER.
             */
            'role' => 'USER',

            'status' => 'Activo',
        ]);

        UserRegistered::emit($user->uuid);
        return redirect('/login')
            ->with(
                'success',
                'Cuenta creada correctamente. Ahora puedes iniciar sesión.'
            );
    }

    // LOGIN
    public function login(Request $request)
    {
        /*
         * Validar formulario
         */
        $request->validate([
            'email' => [
                'required',
                'email'
            ],

            'password' => [
                'required'
            ],
        ]);

        /*
         * Clave utilizada para controlar
         * intentos fallidos.
         *
         * Se combina email + IP.
         */
        $key = Str::lower(
            $request->email . '|' . $request->ip()
        );

        /*
         * Máximo 3 intentos por email + IP.
         * El bloqueo temporal dura 5 minutos.
         */
        if (RateLimiter::tooManyAttempts($key, 3)) {

            return back()
                ->with(
                    'error',
                    'Cuenta bloqueada temporalmente por múltiples intentos fallidos.'
                )
                ->with(
                    'showRecovery',
                    true
                );
        }

        /*
         * Buscar usuario
         */
        $user = User::where(
            'email',
            $request->email
        )->first();

        /*
         * Verificar si la cuenta ya se encuentra bloqueada.
         *
         * Una cuenta bloqueada no debe continuar con la
         * validación de contraseña ni incrementar nuevamente
         * el contador de intentos fallidos.
         */
        if ($user && $user->status === 'Bloqueado') {

            return back()
                ->with(
                    'accountBlocked',
                    true
                );
        }

        /*
         * Verificar credenciales
         */
        if (
            !$user ||
            !Hash::check(
                $request->password,
                $user->password_hash
            )
        ) {

            /*
             * Registrar intento fallido temporal
             * por email + IP.
             */
            RateLimiter::hit(
                $key,
                300
            );

            /*
             * Si el usuario existe, acumular también
             * el intento a nivel de cuenta.
             */
            if ($user) {

                /*
                 * Guardar los valores anteriores
                 * antes de incrementar el contador.
                 */
                $oldStatus = $user->status;

                $oldFailedAttempts =
                    $user->failed_login_attempts;

                $oldLockReason =
                    $user->lock_reason;

                /*
                 * Incrementar contador de intentos
                 * fallidos a nivel de cuenta.
                 */
                $user->failed_login_attempts =
                    $user->failed_login_attempts + 1;

                /*
                 * Bloquear automáticamente la cuenta
                 * al alcanzar 5 intentos fallidos.
                 */
                if ($user->failed_login_attempts >= 5) {

                    $user->status = 'Bloqueado';

                    $user->lock_reason = 'BRUTE_FORCE';

                    /*
                     * Guardar el bloqueo.
                     */
                    $user->save();

                    /*
                     * Revocar todas las sesiones activas
                     * de la cuenta bloqueada.
                     */
                    \DB::table('sessions')
                        ->where(
                            'user_id',
                            $user->uuid
                        )
                        ->delete();

                    /*
                     * Registrar el bloqueo automático
                     * en la auditoría.
                     *
                     * performed_by es NULL porque
                     * ningún administrador realizó
                     * esta acción manualmente.
                     */
                    AuditLog::create([
                        'action' =>
                            'auto_lock_brute_force',

                        'performed_by' =>
                            null,

                        'target_type' =>
                            'User',

                        'target_id' =>
                            $user->uuid,

                        'changes' => [
                            'status' => [
                                'before' =>
                                    $oldStatus,

                                'after' =>
                                    $user->status,
                            ],

                            'failed_login_attempts' => [
                                'before' =>
                                    $oldFailedAttempts,

                                'after' =>
                                    $user->failed_login_attempts,
                            ],

                            'lock_reason' => [
                                'before' =>
                                    $oldLockReason,

                                'after' =>
                                    $user->lock_reason,
                            ],
                        ],
                    ]);

                    /*
                     * Mostrar la ventana de cuenta bloqueada.
                     */
                    return back()
                        ->with(
                            'accountBlocked',
                            true
                        );
                }

                /*
                 * Guardar el nuevo contador cuando
                 * todavía no se alcanza el límite.
                 */
                $user->save();
            }

            /*
             * Mostrar los intentos temporales
             * restantes para la combinación
             * email + IP.
             */
            $attemptsLeft =
                3 - RateLimiter::attempts($key);

            return back()->with(
                'error',
                'Credenciales inválidas. Intentos restantes: ' .
                max($attemptsLeft, 0)
            );
        }

        /*
         * Verificar estado de la cuenta
         */
        if ($user && $user->status === 'Bloqueado') {

            return back()
                ->with(
                    'accountBlocked',
                    true
                );
        }

        /*
         * Credenciales correctas.
         *
         * Reiniciar el contador de intentos fallidos
         * acumulados a nivel de cuenta.
         */
        $user->failed_login_attempts = 0;

        $user->lock_reason = null;

        $user->save();

        /*
         * Limpiar el límite temporal
         * de email + IP.
         */
        RateLimiter::clear($key);

        /*
         * ADMIN y MODERATOR requieren
         * un segundo factor antes de
         * crear la sesión autenticada.
         */
        if (
            in_array(
                $user->role,
                ['ADMIN', 'MODERATOR']
            )
        ) {

            /*
             * Regenerar la sesión antes de
             * almacenar el estado temporal.
             */
            $request->session()->regenerate();

            /*
             * Guardar únicamente el UUID del usuario
             * pendiente de completar 2FA.
             *
             * No se crea todavía una sesión Laravel
             * autenticada.
             */
            $request->session()->put(
                '2fa_pending_user_uuid',
                $user->uuid
            );

            /*
             * Limpiar cualquier verificación
             * administrativa anterior.
             */
            $request->session()->forget([
                'admin_verified',
                'admin_verified_user',
            ]);

            /*
             * Si todavía no tiene 2FA configurado,
             * debe realizar la configuración inicial.
             */
            if (!$user->google2fa_enabled) {

                return redirect()->route(
                    'two-factor.setup'
                );
            }

            /*
             * Si ya tiene 2FA configurado,
             * solicitar el código TOTP.
             */
            return redirect()->route(
                'two-factor.verify'
            );
        }

        /*
         * Usuario normal.
         *
         * USER no utiliza 2FA.
         */
        Auth::login($user);

        /*
         * Regenerar sesión para evitar
         * session fixation.
         */
        $request->session()->regenerate();

        /*
         * Eliminar cualquier verificación
         * administrativa anterior.
         */
        $request->session()->forget([
            'admin_verified',
            'admin_verified_user',
            '2fa_pending_user_uuid'
        ]);

        return redirect('/dashboard');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        /*
         * Eliminar estados temporales
         * de autenticación.
         */
        $request->session()->forget([
            'admin_verified',
            'admin_verified_user',
            'admin_verified_at',
            '2fa_pending_user_uuid',
            'last_activity',
        ]);

        /*
         * Cerrar sesión Laravel.
         */
        Auth::logout();

        /*
         * Invalidar completamente la sesión.
         */
        $request->session()->invalidate();

        /*
         * Generar nuevo token CSRF.
         */
        $request->session()->regenerateToken();

        /*
         * Regresar al login.
         */
        return redirect('/login');
    }

    // LOGIN CON GOOGLE MEDIANTE FIREBASE
    public function googleLogin(
        Request $request,
        FirebaseAuth $firebaseAuth
    ) {

        $request->validate([
            'idToken' => [
                'required',
                'string'
            ],
        ]);

        try {

            /*
             * Verificar que el token realmente
             * fue emitido por Firebase.
             */
            $verifiedIdToken =
                $firebaseAuth->verifyIdToken(
                    $request->idToken
                );

            /*
             * Obtener UID de Firebase.
             */
            $firebaseUid =
                $verifiedIdToken
                    ->claims()
                    ->get('sub');

            /*
             * Obtener información completa
             * del usuario de Firebase.
             */
            $firebaseUser =
                $firebaseAuth->getUser(
                    $firebaseUid
                );

            /*
             * Google debe proporcionar
             * un correo electrónico.
             */
            if (!$firebaseUser->email) {

                return response()->json([
                    'success' => false,
                    'message' =>
                        'La cuenta de Google no tiene un correo electrónico asociado.'
                ], 422);
            }

            /*
             * Para este flujo exigimos que
             * el correo esté verificado.
             */
            if (!$firebaseUser->emailVerified) {

                return response()->json([
                    'success' => false,
                    'message' =>
                        'El correo de la cuenta de Google no está verificado.'
                ], 403);
            }

            /*
             * Buscar primero por Firebase UID.
             */
            $user = User::where(
                'firebase_uid',
                $firebaseUid
            )->first();

            /*
             * Si no existe, buscar por correo.
             *
             * Esto permite vincular una cuenta
             * existente de la plataforma con Google.
             */
            if (!$user) {

                $user = User::where(
                    'email',
                    $firebaseUser->email
                )->first();
            }

            /*
             * Si el usuario todavía no existe
             * en MySQL, crearlo.
             */
            if (!$user) {

                /*
                 * Obtener nombre de Google.
                 */
                $displayName =
                    trim(
                        $firebaseUser->displayName ?? ''
                    );

                $nameParts =
                    preg_split(
                        '/\s+/',
                        $displayName
                    );

                $firstName =
                    $nameParts[0] ?? 'Usuario';

                $lastName =
                    count($nameParts) > 1
                        ? implode(
                            ' ',
                            array_slice(
                                $nameParts,
                                1
                            )
                        )
                        : 'Google';

                /*
                 * Crear un nickname único.
                 */
                $baseNickname =
                    'usuario_' .
                    Str::lower(
                        Str::random(8)
                    );

                $nickname =
                    $baseNickname;

                while (
                    User::where(
                        'anonymous_nickname',
                        $nickname
                    )->exists()
                ) {

                    $nickname =
                        'usuario_' .
                        Str::lower(
                            Str::random(8)
                        );
                }

                $user = User::create([

                    'uuid' =>
                        (string) Str::uuid(),

                    'firebase_uid' =>
                        $firebaseUid,

                    'first_name' =>
                        $firstName,

                    'last_name' =>
                        $lastName,

                    'email' =>
                        $firebaseUser->email,

                    'anonymous_nickname' =>
                        $nickname,

                    'provider' =>
                        'GOOGLE',

                    /*
                     * Google no necesita una contraseña
                     * local para este tipo de cuenta.
                     */
                    'password_hash' =>
                        null,

                    'role' =>
                        'USER',

                    'status' =>
                        'Activo',

                    'must_change_password' =>
                        false,

                    'phone' =>
                        $firebaseUser->phoneNumber,

                    'profile_image' =>
                        $firebaseUser->photoUrl,
                ]);
                UserRegistered::emit($user->uuid);
            } else {

                /*
                 * Vincular el UID real de Firebase
                 * con el usuario existente.
                 */
                $user->firebase_uid =
                    $firebaseUid;

                /*
                 * Mantener la cuenta activa
                 * únicamente si no tiene estado.
                 */
                if (!$user->status) {

                    $user->status =
                        'Activo';
                }

                $user->save();
            }

            /*
             * Verificar estado de la cuenta.
             */
            if ($user->status !== 'Activo') {

                return response()->json([
                    'success' => false,
                    'accountBlocked' => true,
                    'message' =>
                        'Tu cuenta se encuentra bloqueada. Contacta a un administrador.'
                ], 403);
            }

            /*
 * Primer acceso de un moderador:
 * cambiar la contraseña antes del 2FA.
 */
if (
    $user->role === 'MODERATOR' &&
    $user->must_change_password
) {
    $request->session()->regenerate();

    $request->session()->put(
        '2fa_pending_user_uuid',
        $user->uuid
    );

    $request->session()->forget([
        'admin_verified',
        'admin_verified_user',
        'admin_verified_at',
    ]);

    return redirect()->route('password.change');
}

            /*
             * ADMIN y MODERATOR requieren
             * un segundo factor antes de
             * crear la sesión autenticada.
             */
            if (
                in_array(
                    $user->role,
                    ['ADMIN', 'MODERATOR']
                )
            ) {

                /*
                 * Regenerar la sesión antes de
                 * almacenar el estado temporal.
                 */
                $request->session()->regenerate();

                /*
                 * Guardar únicamente el UUID del usuario
                 * pendiente de completar 2FA.
                 *
                 * Todavía NO se crea la sesión autenticada.
                 */
                $request->session()->put(
                    '2fa_pending_user_uuid',
                    $user->uuid
                );

                /*
                 * Limpiar cualquier verificación
                 * administrativa anterior.
                 */
                $request->session()->forget([
                    'admin_verified',
                    'admin_verified_user'
                ]);

                /*
                 * Si no tiene 2FA configurado,
                 * realizar la configuración inicial.
                 */
                if (!$user->google2fa_enabled) {

                    return response()->json([
                        'success' => true,
                        'redirect' =>
                            route(
                                'two-factor.setup'
                            )
                    ]);
                }

                /*
                 * Si ya tiene 2FA configurado,
                 * solicitar el código TOTP.
                 */
                return response()->json([
                    'success' => true,
                    'redirect' =>
                        route(
                            'two-factor.verify'
                        )
                ]);
            }

            /*
             * USER no utiliza 2FA.
             */
            Auth::login($user);

            /*
             * Regenerar sesión.
             */
            $request->session()->regenerate();

            /*
             * Eliminar estados temporales.
             */
            $request->session()->forget([
                'admin_verified',
                'admin_verified_user',
                '2fa_pending_user_uuid'
            ]);

            /*
             * Respuesta al navegador.
             */
            return response()->json([
                'success' => true,
                'redirect' =>
                    route('dashboard')
            ]);

        } catch (\Throwable $e) {

    /*
     * Registrar la excepción para diagnóstico.
     * Laravel la enviará a los logs del servidor.
     */
    report($e);

    /*
     * No mostrar detalles internos
     * de Firebase al usuario.
     */
    return response()->json([
        'success' => false,
        'message' =>
            'No fue posible iniciar sesión con Google.'
    ], 401);
    }
    }
}