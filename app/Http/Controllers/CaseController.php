<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseFile;
use App\Models\User;

class CaseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Crear caso de Suicidio
    |--------------------------------------------------------------------------
    */

    public function createSuicideCase(Request $request)
    {
        $request->validate([

            'description' => 'required|min:10'

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
                'Caso creado correctamente. Número: '
                .$case->case_number
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Crear caso de Abuso Sexual
    |--------------------------------------------------------------------------
    */

    public function createAbuseCase(Request $request)
    {
        $request->validate([

            'description' => 'required|min:10'

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
                'Caso creado correctamente. Número: '
                .$case->case_number
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Asignación automática de moderador
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Generar número de caso
    |--------------------------------------------------------------------------
    */

    private function generateCaseNumber()
    {
        $last = CaseFile::count() + 1;

        return 'VS-'.date('Y').'-'.str_pad(
            $last,
            4,
            '0',
            STR_PAD_LEFT
        );
    }
}