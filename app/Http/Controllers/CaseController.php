<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseFile;
use App\Models\User;
use App\Models\SystemSetting;

class CaseController extends Controller
{
    //CREAR CASO DE SUICIDIO
    
    public function createSuicideCase(Request $request)
    {
        $settings = SystemSetting::first();
        if (!$settings || !$settings->case_creation_enabled) {

            return back()->with(
                'error',
                'La creación de nuevos casos está temporalmente deshabilitada.'
            );
        }

        $request->validate([
            'description' => 'required|string|min:10'
        ]);

        $moderator = $this->assignModerator();
        $case = CaseFile::create([
            'case_number' => $this->generateCaseNumber(),
            'type' => 'Suicidio',
            'description' => $request->description,
            'user_uuid' => Auth::user()->uuid,
            'moderator_uuid' => $moderator?->uuid,
            'status' => 'Abierto',
            'admin_approved' => false
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Caso creado correctamente. Número: ' .
                $case->case_number
            );
    }


    //CREAR CASO DE ABUSO SEXUAL

    public function createAbuseCase(Request $request)
    {
        $settings = SystemSetting::first();

        if (!$settings || !$settings->case_creation_enabled) {

            return back()->with(
                'error',
                'La creación de nuevos casos está temporalmente deshabilitada.'
            );
        }

        $request->validate([
            'description' => 'required|string|min:10'
        ]);

        $moderator = $this->assignModerator();
        $case = CaseFile::create([
            'case_number' => $this->generateCaseNumber(),
            'type' => 'Abuso sexual',
            'description' => $request->description,
            'user_uuid' => Auth::user()->uuid,
            'moderator_uuid' => $moderator?->uuid,
            'status' => 'Abierto',
            'admin_approved' => false
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Caso creado correctamente. Número: ' .
                $case->case_number
            );
    }


    //ASIGNACIÓN AUTOMÁTICA DE MODERADOR

    private function assignModerator()
    {
        return User::where(
                'role',
                'MODERATOR'
            )
            ->where(
                'status',
                'Activo'
            )
            ->get()
            ->sortBy(function ($moderator) {

                return CaseFile::where(
                    'moderator_uuid',
                    $moderator->uuid
                )
                ->where(
                    'status',
                    'Abierto'
                )
                ->count();

            })
            ->first();
    }


    //GENERAR NÚMERO DE CASO

    private function generateCaseNumber()
    {
        $last = CaseFile::count() + 1;

        return 'VS-' . date('Y') . '-' . str_pad(
            $last,
            4,
            '0',
            STR_PAD_LEFT
        );
    }
    
    // VER SEGUIMIENTO DE CASO

public function tracking(Request $request)
{
    $user = Auth::user();

    $case = null;

    if ($request->filled('anonymous_nickname') && $request->filled('case_number')) {

        // Verificar que el nombre de usuario pertenece
        // al usuario actualmente autenticado
        $userMatches = User::where(
            'uuid',
            $user->uuid
        )
        ->where(
            'anonymous_nickname',
            $request->anonymous_nickname
        )
        ->exists();

        if (!$userMatches) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'El nombre de usuario no corresponde con tu cuenta.'
                );
        }

        // Buscar el caso por número y UUID del usuario
        $case = CaseFile::where(
            'case_number',
            $request->case_number
        )
        ->where(
            'user_uuid',
            $user->uuid
        )
        ->with([
            'comments' => function ($query) {
                $query->with('user')
                    ->orderBy('created_at', 'asc');
            },
            'moderator'
        ])
        ->first();

        if (!$case) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se encontró un caso con los datos proporcionados.'
                );
        }
    }

    return view(
        'cases',
        compact('case')
    );
}
}