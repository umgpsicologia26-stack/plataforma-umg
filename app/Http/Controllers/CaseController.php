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
            'type' => 'SUICIDIO',
            'description' => $request->description,
            'user_uuid' => Auth::user()->uuid,
            'moderator_uuid' => $moderator?->uuid,
            'status' => 'ABIERTO',
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
            'type' => 'ABUSO_SEXUAL',
            'description' => $request->description,
            'user_uuid' => Auth::user()->uuid,
            'moderator_uuid' => $moderator?->uuid,
            'status' => 'ABIERTO',
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
                'ACTIVE'
            )
            ->get()
            ->sortBy(function ($moderator) {

                return CaseFile::where(
                    'moderator_uuid',
                    $moderator->uuid
                )
                ->where(
                    'status',
                    'ABIERTO'
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
}