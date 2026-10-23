<?php 
namespace App\Http\Controllers; 

use App\Models\CaseFile; 
use App\Models\CaseComment; 
use App\Models\CaseNotification; 
use App\Models\AdminNotification;
use App\Models\ChatConversation; 
use App\Models\AuditLog; 
use App\Events\CaseActivityUpdated;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str; 

class CaseController extends BaseController 
{ 
    /* CREAR CASO DE SUICIDIO */ 

    public function createSuicideCase(Request $request) 
    { 
        $this->authorize('create', CaseFile::class);

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

        /* BUSCAR MODERADOR CON MENOS CASOS PENDIENTES */

        $moderator = $this->assignModerator();

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
        ]); 

        AuditLog::create([ 
            'action' => 'create_case', 
            'performed_by' => $user->uuid, 
            'target_type' => 'CaseFile', 
            'target_id' => (string) $case->id, 
            'changes' => [ 
                'case_number' => $case->case_number, 
                'type' => $case->type, 
                'status' => $case->status, 
            ], 
        ]); 

        /* NOTIFICAR AL MODERADOR */ 

        if ($moderator) { 

            $columns = DB::getSchemaBuilder() 
                ->getColumnListing('case_notifications'); 

            if (in_array('moderator_uuid', $columns)) { 

                DB::table('case_notifications')->insert([ 
                    'user_uuid'      => $user->uuid, 
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

                // NOTIFICAR EN TIEMPO REAL QUE SE CREÓ EL CASO
        CaseActivityUpdated::emit($case, null, 'case.created');

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
        $this->authorize('create', CaseFile::class);

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

        /* BUSCAR MODERADOR CON MENOS CASOS PENDIENTES */

        $moderator = $this->assignModerator();

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
        ]); 

        AuditLog::create([ 
            'action' => 'create_case', 
            'performed_by' => $user->uuid, 
            'target_type' => 'CaseFile', 
            'target_id' => (string) $case->id, 
            'changes' => [ 
                'case_number' => $case->case_number, 
                'type' => $case->type, 
                'status' => $case->status, 
            ], 
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
                    'user_uuid' => $user->uuid, 
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

        // NOTIFICAR EN TIEMPO REAL QUE SE CREÓ EL CASO
            event(new CaseActivityUpdated(
                $case,
                null,
                'case.created'
            ));

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
            'comments' => function ($query) {
                // Las observaciones del administrador solo las ve el moderador.
                $query->whereNotIn(
                    'user_id',
                    DB::table('users')->where('role', 'ADMIN')->select('uuid')
                )->with('user');
            },
        ])

            ->where( 
                'user_uuid', 
                $userUuid 
            ) 
            ->orderByDesc( 
                'created_at' 
            ) 
            ->get(); 

        /* CARGAR RESPUESTAS DEL MODERADOR DESDE EL CHAT */ 

        $conversations = ChatConversation::with([ 
            'messages.sender' 
        ]) 
            ->where('user_uuid', $userUuid) 
            ->get(); 

        foreach ($cases as $case) { 

            $conversation = $conversations->first(function ($conversation) use ($case) { 

                return $conversation->moderator_uuid === $case->moderator_uuid; 

            }); 

            $case->moderator_messages = $conversation 
                ? $conversation->messages 
                : collect(); 
        } 

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

    /* RESPONDER AL SEGUIMIENTO DE UN CASO */
    public function replyToCase(Request $request, $id)
    {
        $this->checkRole(['USER']);

        $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $user = Auth::user();

        $case = CaseFile::query()
            ->where('id', $id)
            ->where('user_uuid', $user->uuid)
            ->whereIn('status', ['Abierto', 'En seguimiento'])
            ->firstOrFail();

        return DB::transaction(function () use ($request, $user, $case) {

            $comment = CaseComment::create([
                'case_id' => $case->id,
                'user_id' => $user->uuid,
                'type' => 'RESPUESTA_USUARIO',
                'comment' => trim($request->input('message')),
                'color' => null,
            ]);

            // Se emite al confirmarse la transacción (lo hace emit()).
                CaseActivityUpdated::emit($case, $comment, 'case.comment.created');

            if ($case->moderator_uuid) {
                CaseNotification::create([
                    'user_uuid' => $user->uuid,
                    'moderator_uuid' => $case->moderator_uuid,
                    'case_id' => $case->id,
                    'comment_id' => $comment->id,
                    'message' => 'El usuario ha respondido al seguimiento del caso ' .
                        $case->case_number . '.',
                    'read_at' => null,
                ]);
            }

            AuditLog::create([
                'action' => 'user_reply_to_case',
                'performed_by' => $user->uuid,
                'target_type' => 'CaseFile',
                'target_id' => (string) $case->id,
                'changes' => [
                    'case_number' => $case->case_number,
                    'comment_id' => $comment->id,
                    'type' => 'RESPUESTA_USUARIO',
                ],
            ]);

                        try {
                AdminNotification::notifyAdmins(
                    $case,
                    'El usuario respondió en el seguimiento del caso '
                        . $case->case_number . '.',
                    false
                );
            } catch (\Throwable $e) {
                report($e);
            }

            return redirect()
                ->route('cases.tracking')
                ->with('success', 'Tu respuesta se envió correctamente.');
        });
    }

    /**
     * Asignar casos mediante un turno rotativo entre moderadores activos.
     */
    private function assignModerator()
    {
        return DB::transaction(function () {
            // Bloquear el registro para evitar que dos solicitudes
            // avancen el turno al mismo tiempo.
            $state = DB::table('moderator_assignment_state')
                ->where('id', 1)
                ->lockForUpdate()
                ->first();

            if (!$state) {
                throw new \RuntimeException(
                    'No existe el registro de estado de asignación de moderadores.'
                );
            }

            // Obtener únicamente moderadores activos y no eliminados.
            $moderators = DB::table('users')
                ->where('role', 'MODERATOR')
                ->where('status', 'Activo')
                ->whereNull('deleted_at')
                ->orderBy('uuid')
                ->get();

            if ($moderators->isEmpty()) {
                return null;
            }

            $lastUuid = $state->last_moderator_uuid;

            // Seleccionar el siguiente moderador después del último turno.
            $nextModerator = $lastUuid
                ? $moderators->first(function ($moderator) use ($lastUuid) {
                    return strcmp($moderator->uuid, $lastUuid) > 0;
                })
                : null;

            // Si llegamos al final de la lista, volver al principio.
            if (!$nextModerator) {
                $nextModerator = $moderators->first();
            }

            // Persistir el turno para la próxima asignación.
            DB::table('moderator_assignment_state')
                ->where('id', 1)
                ->update([
                    'last_moderator_uuid' => $nextModerator->uuid,
                    'updated_at' => now(),
                ]);

            return $nextModerator;
        });
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
