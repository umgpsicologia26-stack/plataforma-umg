<?php

namespace App\Http\Controllers;

use App\Models\CaseFile;
use App\Models\CaseComment;
use App\Models\CaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CaseController extends BaseController
{
    /* CREAR CASO DE SUICIDIO */

    public function createSuicideCase(Request $request)
    {
        $this->checkRole(['USER']);

        $request->validate([
            'description' => [
                'required',
                'string',
                'max:5000'
            ],
        ]);

        /* VERIFICAR CONFIGURACIÓN */

        $settings = DB::table('system_settings')->first();

        if (
            $settings &&
            isset($settings->case_creation_enabled) &&
            !$settings->case_creation_enabled
        ) {
            return back()->with(
                'error',
                'Actualmente la creación de casos se encuentra deshabilitada.'
            );
        }

        /* USUARIO */

        $user = Auth::user();

        /* BUSCAR MODERADOR DISPONIBLE */

        $moderator = DB::table('users')
            ->where('role', 'MODERATOR')
            ->where('status', 'ACTIVO')
            ->orderBy('created_at', 'asc')
            ->first();

        /* NÚMERO DE CASO */

        $caseNumber = $this->generateCaseNumber();

        /* CREAR CASO */

        $case = CaseFile::create([
            'case_number'   => $caseNumber,
            'type'          => 'Suicidio',
            'description'   => trim($request->description),
            'user_uuid'     => $user->uuid,
            'moderator_uuid'=> $moderator?->uuid,
            'status'        => 'Abierto',
            'priority'      => 'Media',
            'admin_approved'=> false,
        ]);

        /* NOTIFICAR AL MODERADOR */

        if ($moderator) {

            
            $columns = DB::getSchemaBuilder()
                ->getColumnListing('case_notifications');

            if (in_array('moderator_uuid', $columns)) {

                DB::table('case_notifications')->insert([
                    'moderator_uuid' => $moderator->uuid,
                    'case_id'        => $case->id,
                    'message'        =>
                        'Se ha asignado un nuevo caso de tipo Suicidio: ' .
                        $case->case_number,
                    'read_at'        => null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        return redirect()
            ->route('cases.tracking')
            ->with(
                'success',
                'Tu caso fue registrado correctamente. Número de caso: ' .
                $case->case_number
            );
    }


    /* CREAR CASO DE ABUSO SEXUAL */

    public function createAbuseCase(Request $request)
    {
        $this->checkRole(['USER']);

        $request->validate([
            'description' => [
                'required',
                'string',
                'max:5000'
            ],
        ]);

        /* VERIFICAR CONFIGURACIÓN */

        $settings = DB::table('system_settings')->first();

        if (
            $settings &&
            isset($settings->case_creation_enabled) &&
            !$settings->case_creation_enabled
        ) {
            return back()->with(
                'error',
                'Actualmente la creación de casos se encuentra deshabilitada.'
            );
        }

        /* USUARIO */

        $user = Auth::user();

        /* BUSCAR MODERADOR DISPONIBLE */

        $moderator = DB::table('users')
            ->where('role', 'MODERATOR')
            ->where('status', 'ACTIVO')
            ->orderBy('created_at', 'asc')
            ->first();

        /* NÚMERO DE CASO */

        $caseNumber = $this->generateCaseNumber();

        /* CREAR CASO */

        $case = CaseFile::create([
            'case_number'   => $caseNumber,
            'type'          => 'Abuso sexual',
            'description'   => trim($request->description),
            'user_uuid'     => $user->uuid,
            'moderator_uuid'=> $moderator?->uuid,
            'status'        => 'Abierto',
            'priority'      => 'Media',
            'admin_approved'=> false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | NOTIFICAR AL MODERADOR
        |--------------------------------------------------------------------------
        */

        if ($moderator) {

            $columns = DB::getSchemaBuilder()
                ->getColumnListing('case_notifications');

            if (in_array('moderator_uuid', $columns)) {

                DB::table('case_notifications')->insert([
                    'moderator_uuid' => $moderator->uuid,
                    'case_id'        => $case->id,
                    'message'        =>
                        'Se ha asignado un nuevo caso de tipo Abuso sexual: ' .
                        $case->case_number,
                    'read_at'        => null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        return redirect()
            ->route('cases.tracking')
            ->with(
                'success',
                'Tu caso fue registrado correctamente. Número de caso: ' .
                $case->case_number
            );
    }


    /* GENERAR NÚMERO DE CASO */

    private function generateCaseNumber()
    {
        do {

            $number = random_int(1, 9999);

            $caseNumber =
                'VS-' .
                date('Y') .
                '-' .
                str_pad(
                    $number,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

        } while (
            CaseFile::where(
                'case_number',
                $caseNumber
            )->exists()
        );

        return $caseNumber;
    }


    /* SEGUIMIENTO DE CASOS DEL USUARIO */

    public function tracking()
    {
        $this->checkRole(['USER']);

        $userUuid = Auth::user()->uuid;

        /* OBTENER TODOS LOS CASOS DEL USUARIO */

        $cases = CaseFile::with([
            'user',
            'moderator',
            'comments.user'
        ])
            ->where(
                'user_uuid',
                $userUuid
            )
            ->orderByDesc(
                'created_at'
            )
            ->get();

        /* SEPARAR POR TIPO */

        $suicideCases = $cases
            ->filter(function ($case) {

                return strtolower(
                    trim($case->type)
                ) === 'suicidio';

            });

        $abuseCases = $cases
            ->filter(function ($case) {

                $type = strtolower(
                    trim($case->type)
                );

                return $type === 'abuso sexual'
                    || $type === 'abusosexual'
                    || $type === 'abuso_sexual';

            });


        /* SUICIDIO - ABIERTOS */

        $suicideOpen = $suicideCases
            ->filter(function ($case) {

                return strtolower(
                    trim($case->status)
                ) === 'abierto';

            });


        /* SUICIDIO - EN SEGUIMIENTO */

        $suicideFollowUp = $suicideCases
            ->filter(function ($case) {

                return strtolower(
                    trim($case->status)
                ) === 'en seguimiento';

            });


        /* SUICIDIO - CERRADOS */

        $suicideClosed = $suicideCases
            ->filter(function ($case) {

                return strtolower(
                    trim($case->status)
                ) === 'cerrado';

            });


        /* ABUSO SEXUAL - ABIERTOS */

        $abuseOpen = $abuseCases
            ->filter(function ($case) {

                return strtolower(
                    trim($case->status)
                ) === 'abierto';

            });


        /* ABUSO SEXUAL - EN SEGUIMIENTO */

        $abuseFollowUp = $abuseCases
            ->filter(function ($case) {

                return strtolower(
                    trim($case->status)
                ) === 'en seguimiento';

            });


        /* ABUSO SEXUAL - CERRADOS */

        $abuseClosed = $abuseCases
            ->filter(function ($case) {

                return strtolower(
                    trim($case->status)
                ) === 'cerrado';

            });


        /* CONTADORES */

        $totalCases = $cases->count();

        $totalSuicide = $suicideCases->count();

        $totalAbuse = $abuseCases->count();

        $totalOpen =
            $suicideOpen->count() +
            $abuseOpen->count();

        $totalFollowUp =
            $suicideFollowUp->count() +
            $abuseFollowUp->count();

        $totalClosed =
            $suicideClosed->count() +
            $abuseClosed->count();


        /* MARCAR NOTIFICACIONES COMO LEÍDAS */

        if ($cases->isNotEmpty()) {

            $caseIds = $cases
                ->pluck('id')
                ->toArray();

            CaseNotification::where(
                'user_uuid',
                $userUuid
            )
                ->whereIn(
                    'case_id',
                    $caseIds
                )
                ->whereNull(
                    'read_at'
                )
                ->update([
                    'read_at' => now()
                ]);
        }


        /* MOSTRAR VISTA */

        return view(
            'cases',
            compact(
                'cases',

                'suicideCases',
                'suicideOpen',
                'suicideFollowUp',
                'suicideClosed',

                'abuseCases',
                'abuseOpen',
                'abuseFollowUp',
                'abuseClosed',

                'totalCases',
                'totalSuicide',
                'totalAbuse',
                'totalOpen',
                'totalFollowUp',
                'totalClosed'
            )
        );
    }


    /* MARCAR NOTIFICACIÓN COMO LEÍDA */

    public function markNotificationAsRead($id)
    {
        $this->checkRole(['USER']);

        $notification = CaseNotification::where(
            'id',
            $id
        )
            ->where(
                'user_uuid',
                Auth::user()->uuid
            )
            ->firstOrFail();

        $notification->update([
            'read_at' => now()
        ]);

        return back();
    }
}