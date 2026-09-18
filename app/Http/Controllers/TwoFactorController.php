<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use PragmaRX\Google2FALaravel\Google2FA;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
class TwoFactorController extends Controller
{
    /**
     * Muestra la pantalla para configurar 2FA.
     */
    public function showSetup(Request $request)
    {
        $userUuid = $request->session()->get('2fa_pending_user_uuid');

        if (!$userUuid) {
            return redirect()->route('login');
        }

        $user = User::where('uuid', $userUuid)->first();

        if (!$user || !in_array($user->role, ['ADMIN', 'MODERATOR'])) {
            $request->session()->forget('2fa_pending_user_uuid');

            return redirect()->route('login');
        }

        $google2fa = app(Google2FA::class);

        // Si todavía no existe un secreto, se genera.
        if (!$user->google2fa_secret) {
            $secret = $google2fa->generateSecretKey(16);

            $user->google2fa_secret = $secret;
            $user->save();
        }

       $qrCodeUrl = $google2fa->getQRCodeUrl(
    'UMG',
    $user->email,
    $user->google2fa_secret
);

$options = new QROptions([
    'outputBase64' => false,
]);

$qrCode = (new QRCode($options))->render($qrCodeUrl);

        return view('auth.2fa-setup', [
    'user' => $user,
    'qrCode' => $qrCode,
]);
    }

    /**
     * Activa 2FA después de verificar el primer código.
     */
    public function enable(Request $request)
    {
        $request->validate([
            'one_time_password' => [
                'required',
                'digits:6',
            ],
        ]);

        $userUuid = $request->session()->get('2fa_pending_user_uuid');

        if (!$userUuid) {
            return redirect()->route('login');
        }

        $user = User::where('uuid', $userUuid)->first();

        if (!$user || !in_array($user->role, ['ADMIN', 'MODERATOR'])) {
            $request->session()->forget('2fa_pending_user_uuid');

            return redirect()->route('login');
        }

        $key = '2fa-enable:' . $user->uuid . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'one_time_password' =>
                    'Demasiados intentos. Intenta nuevamente más tarde.',
            ]);
        }

        $google2fa = app(Google2FA::class);

        $valid = $google2fa->verifyGoogle2FA(
            $user->google2fa_secret,
            $request->one_time_password
        );

        if (!$valid) {
            RateLimiter::hit($key, 300);

            return back()->withErrors([
                'one_time_password' =>
                    'El código de verificación no es válido.',
            ]);
        }

        RateLimiter::clear($key);

        $user->google2fa_enabled = true;
        $user->save();

        AuditLog::create([
            'action' => 'enable_2fa',
            'performed_by' => $user->uuid,
            'target_type' => User::class,
            'target_id' => $user->uuid,
            'changes' => [
                'google2fa_enabled' => true,
            ],
        ]);

        return redirect()->route('two-factor.verify');
    }

    /**
     * Muestra la pantalla para ingresar el código 2FA.
     */
    public function showVerify(Request $request)
    {
        $userUuid = $request->session()->get('2fa_pending_user_uuid');

        if (!$userUuid) {
            return redirect()->route('login');
        }

        $user = User::where('uuid', $userUuid)->first();

        if (!$user || !in_array($user->role, ['ADMIN', 'MODERATOR'])) {
            $request->session()->forget('2fa_pending_user_uuid');

            return redirect()->route('login');
        }

        if (!$user->google2fa_enabled) {
            return redirect()->route('two-factor.setup');
        }

        return view('auth.2fa-verify', [
            'user' => $user,
        ]);
    }

    /**
     * Verifica el código TOTP y completa el inicio de sesión.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => [
                'required',
                'digits:6',
            ],
        ]);

        $userUuid = $request->session()->get('2fa_pending_user_uuid');

        if (!$userUuid) {
            return redirect()->route('login');
        }

        $user = User::where('uuid', $userUuid)->first();

        if (!$user || !in_array($user->role, ['ADMIN', 'MODERATOR'])) {
            $request->session()->forget('2fa_pending_user_uuid');

            return redirect()->route('login');
        }

        if (!$user->google2fa_enabled || !$user->google2fa_secret) {
            return redirect()->route('two-factor.setup');
        }

        $key = '2fa-verify:' . $user->uuid . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'one_time_password' =>
                    'Demasiados intentos. Intenta nuevamente más tarde.',
            ]);
        }

        $google2fa = app(Google2FA::class);

        $valid = $google2fa->verifyGoogle2FA(
            $user->google2fa_secret,
            $request->one_time_password
        );

        if (!$valid) {
            RateLimiter::hit($key, 300);

            return back()->withErrors([
                'one_time_password' =>
                    'El código de verificación no es válido.',
            ]);
        }

        RateLimiter::clear($key);

        Auth::login($user);

        $request->session()->regenerate();

        $request->session()->forget([
            '2fa_pending_user_uuid',
            'admin_verified',
            'admin_verified_user',
        ]);

        if ($user->role === 'MODERATOR' && $user->must_change_password) {
            return redirect()->route('password.change');
        }

        return redirect()->route('dashboard');
    }

    /**
     * Cancela el proceso de autenticación 2FA pendiente.
     */
    public function cancel(Request $request)
    {
        $request->session()->forget('2fa_pending_user_uuid');

        return redirect()->route('login');
    }
}