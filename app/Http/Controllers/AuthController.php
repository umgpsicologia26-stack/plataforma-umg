<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //MOSTRAR LOGIN
    
    public function showLogin()
    {
        return view('auth.login');
    }


    //REGISTRO PÚBLICO

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


        User::create([

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


        return redirect('/login')
            ->with(
                'success',
                'Cuenta creada correctamente. Ahora puedes iniciar sesión.'
            );
    }


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
     * Se combina email + IP.
     */
    $key = Str::lower(
        $request->email . '|' . $request->ip()
    );


    /*
     * Máximo 3 intentos.
     * El bloqueo dura 5 minutos.
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


    //Buscar usuario
    $user = User::where(
        'email',
        $request->email
    )->first();


    //Verificar credenciales
    if (
        !$user ||
        !Hash::check(
            $request->password,
            $user->password_hash
        )
    ) 
    
    {
        RateLimiter::hit(
            $key,
            300
        );

        $attemptsLeft =
            3 - RateLimiter::attempts($key);

        return back()->with(
            'error',
            'Credenciales inválidas. Intentos restantes: ' .
            max($attemptsLeft, 0)
        );
    }


    //Verificar estado de la cuenta
        if ($user->status !== 'Activo') {

        return back()->with(
            'error',
            'Tu cuenta se encuentra bloqueada. Contacta a un administrador.'
        );
    }


    //Login correcto
    RateLimiter::clear($key);
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
        'admin_verified_user'
    ]);


    /*
     * MODERADOR NUEVO
     * Si el administrador creó esta cuenta
     * y todavía no ha cambiado la contraseña,
     * debe hacerlo antes de continuar.
     */
    if (
        $user->role === 'MODERATOR' &&
        $user->must_change_password
    ) 

    {
        return redirect('/change-password');
    }


    //Usuario normal, psicólogo o administrador.
        return redirect('/dashboard');
}
    //LOGOUT

    public function logout(Request $request)
    {
        //Eliminar la verificación administrativa.
                $request->session()->forget(
            'admin_verified'
        );


        //Cerrar sesión Laravel.
                Auth::logout();


        //Invalidar completamente la sesión.
                $request->session()->invalidate();


        //Generar nuevo token CSRF.
                $request->session()->regenerateToken();


        //Regresar al login.
                return redirect('/login');
    }
}
