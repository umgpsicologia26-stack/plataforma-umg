<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\EvaluacionPregunta;
use App\Models\EvaluacionRespuesta;
use App\Models\EvaluationAttempt;
use App\Models\ModeratorNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class EvaluacionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USUARIO
    |--------------------------------------------------------------------------
    */

    /**
     * Lista todas las evaluaciones activas.
     */
    public function index()
    {
        $user = Auth::user();

        $evaluaciones = Evaluacion::where('status', 'ACTIVA')
            ->orderBy('created_at', 'desc')
            ->get();

        $evaluacionesCompletadas = [];

        if ($user) {
            $evaluacionesCompletadas = EvaluationAttempt::where(
                    'user_uuid',
                    $user->uuid
                )
                ->where('status', 'COMPLETADA')
                ->pluck('evaluacion_uuid')
                ->toArray();
        }

        return view(
            'evaluations.index',
            compact(
                'evaluaciones',
                'evaluacionesCompletadas'
            )
        );
    }

    /**
     * Mostrar una evaluación específica.
     */
    public function show(string $uuid)
    {
        $user = Auth::user();

        if (!$user) {
            abort(401);
        }

        $evaluacion = Evaluacion::with('preguntas')
            ->where('uuid', $uuid)
            ->where('status', 'ACTIVA')
            ->firstOrFail();

        $yaCompletada = EvaluationAttempt::where(
                'evaluacion_uuid',
                $evaluacion->uuid
            )
            ->where(
                'user_uuid',
                $user->uuid
            )
            ->where(
                'status',
                'COMPLETADA'
            )
            ->exists();

        if ($yaCompletada) {
            return redirect()
                ->route('evaluation.index')
                ->with(
                    'error',
                    'Ya has completado esta evaluación.'
                );
        }

        return view(
            'evaluation',
            compact('evaluacion')
        );
    }

    /**
     * Guardar respuestas de una evaluación.
     */
    public function submit(Request $request, string $uuid)
    {
        $user = Auth::user();

        if (!$user) {
            abort(401);
        }

        $evaluacion = Evaluacion::with('preguntas')
            ->where('uuid', $uuid)
            ->where('status', 'ACTIVA')
            ->firstOrFail();

        $yaCompletada = EvaluationAttempt::where(
                'evaluacion_uuid',
                $evaluacion->uuid
            )
            ->where(
                'user_uuid',
                $user->uuid
            )
            ->where(
                'status',
                'COMPLETADA'
            )
            ->exists();

        if ($yaCompletada) {
            return redirect()
                ->route('evaluation.index')
                ->with(
                    'error',
                    'Ya has completado esta evaluación.'
                );
        }

        $respuestas = $request->input(
            'respuestas',
            []
        );

        if (!is_array($respuestas)) {
            $respuestas = [];
        }

        foreach ($evaluacion->preguntas as $pregunta) {

            if (!$pregunta->required) {
                continue;
            }

            $respuesta = $respuestas[
                $pregunta->uuid
            ] ?? null;

            if (
                $respuesta === null ||
                $respuesta === '' ||
                (
                    is_array($respuesta) &&
                    count($respuesta) === 0
                )
            ) {
                return back()
                    ->withErrors([
                        'respuestas' =>
                            'Debes responder todas las preguntas obligatorias.'
                    ])
                    ->withInput();
            }
        }

        try {

            DB::transaction(function () use (
                $evaluacion,
                $user,
                $respuestas
            ) {

                $yaCompletada = EvaluationAttempt::where(
                        'evaluacion_uuid',
                        $evaluacion->uuid
                    )
                    ->where(
                        'user_uuid',
                        $user->uuid
                    )
                    ->where(
                        'status',
                        'COMPLETADA'
                    )
                    ->exists();

                if ($yaCompletada) {
                    throw new \RuntimeException(
                        'EVALUACION_YA_COMPLETADA'
                    );
                }

                $attempt = EvaluationAttempt::create([
                    'evaluacion_uuid' => $evaluacion->uuid,
                    'user_uuid' => $user->uuid,
                    'status' => 'COMPLETADA',
                    'started_at' => now(),
                    'completed_at' => now(),
                ]);

                foreach (
                    $evaluacion->preguntas
                    as $pregunta
                ) {

                    if (
                        !array_key_exists(
                            $pregunta->uuid,
                            $respuestas
                        )
                    ) {
                        continue;
                    }

                    $respuesta = $respuestas[
                        $pregunta->uuid
                    ];

                    if (is_array($respuesta)) {
                        $respuesta = json_encode(
                            $respuesta,
                            JSON_UNESCAPED_UNICODE
                        );
                    }

                    EvaluacionRespuesta::create([
                        'uuid' => (string) \Illuminate\Support\Str::uuid(),
                        'attempt_uuid' => $attempt->uuid,
                        'evaluacion_uuid' => $evaluacion->uuid,
                        'pregunta_uuid' => $pregunta->uuid,
                        'user_uuid' => $user->uuid,
                        'respuesta' => (string) $respuesta,
                        'completed_at' => now(),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | NOTIFICACIÓN AL MODERADOR
                |--------------------------------------------------------------------------
                */

                if (!empty($evaluacion->created_by)) {

                    $nombreUsuario = '';

                    if (!empty($user->first_name)) {

                        $nombreUsuario = trim(
                            $user->first_name . ' ' .
                            ($user->last_name ?? '')
                        );

                    } elseif (!empty($user->full_name)) {

                        $nombreUsuario = $user->full_name;

                    } else {

                        $nombreUsuario = 'Un usuario';
                    }

                    ModeratorNotification::create([
                        'moderator_uuid' => $evaluacion->created_by,
                        'conversation_id' => null,
                        'evaluacion_uuid' => $evaluacion->uuid,
                        'attempt_uuid' => $attempt->uuid,
                        'message' =>
                            $nombreUsuario .
                            ' ha completado la evaluación "' .
                            $evaluacion->title .
                            '".',
                        'read' => false,
                    ]);
                }
            });

        } catch (\RuntimeException $e) {

            if (
                $e->getMessage() ===
                'EVALUACION_YA_COMPLETADA'
            ) {

                return redirect()
                    ->route('evaluation.index')
                    ->with(
                        'error',
                        'Ya has completado esta evaluación.'
                    );
            }

            throw $e;

        } catch (QueryException $e) {

            if (
                $e->getCode() === '23000' ||
                str_contains(
                    strtolower($e->getMessage()),
                    'duplicate'
                )
            ) {

                return redirect()
                    ->route('evaluation.index')
                    ->with(
                        'error',
                        'Ya has completado esta evaluación.'
                    );
            }

            throw $e;
        }

        return redirect()
            ->route('evaluation.index')
            ->with(
                'success',
                'Evaluación completada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | MODERADOR
    |--------------------------------------------------------------------------
    */

    /**
     * Lista de evaluaciones del moderador.
     *
     * También carga las notificaciones de resultados de evaluaciones
     * creadas exclusivamente por el moderador autenticado.
     */
    public function moderatorIndex()
    {
        $moderatorUuid = Auth::user()->uuid;

        /*
        |--------------------------------------------------------------------------
        | EVALUACIONES CREADAS POR EL MODERADOR
        |--------------------------------------------------------------------------
        */

        $evaluaciones = Evaluacion::with('preguntas')
            ->where('created_by', $moderatorUuid)
            ->orderBy('created_at', 'desc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | NOTIFICACIONES DE EVALUACIONES
        |--------------------------------------------------------------------------
        |
        | Solamente se obtienen notificaciones que:
        |
        | 1. Pertenecen al moderador autenticado.
        | 2. Corresponden a una evaluación.
        | 3. Tienen un intento asociado.
        | 4. La evaluación fue creada por este moderador.
        | 5. El intento está completado.
        |
        */

        $notificacionesEvaluaciones = ModeratorNotification::with([
                'evaluacion',
                'intento.usuario',
                'intento.respuestas.pregunta',
            ])
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->whereNotNull(
                'evaluacion_uuid'
            )
            ->whereNotNull(
                'attempt_uuid'
            )
            ->whereHas(
                'evaluacion',
                function ($query) use ($moderatorUuid) {
                    $query->where(
                        'created_by',
                        $moderatorUuid
                    );
                }
            )
            ->whereHas(
                'intento',
                function ($query) {
                    $query->where(
                        'status',
                        'COMPLETADA'
                    );
                }
            )
            ->orderBy(
                'created_at',
                'desc'
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RESULTADOS PENDIENTES
        |--------------------------------------------------------------------------
        |
        | El contador representa usuarios pendientes de revisión,
        | no cantidad de notificaciones.
        |
        */

        $usuariosPendientes = $notificacionesEvaluaciones
            ->filter(function ($notificacion) {
                return !$notificacion->read;
            })
            ->groupBy(function ($notificacion) {
                return $notificacion->intento?->user_uuid
                    ?? 'sin-usuario-' . $notificacion->id;
            })
            ->count();

        return view(
            'moderator.evaluations.index',
            compact(
                'evaluaciones',
                'notificacionesEvaluaciones',
                'usuariosPendientes'
            )
        );
    }

    /**
     * Mostrar los resultados de las evaluaciones completadas
     * por un usuario específico.
     */
    public function moderatorUserResults(string $userUuid)
    {
        $moderatorUuid = Auth::user()->uuid;

        /*
        |--------------------------------------------------------------------------
        | OBTENER NOTIFICACIONES DEL USUARIO
        |--------------------------------------------------------------------------
        */

        $notificaciones = ModeratorNotification::with([
                'evaluacion',
                'intento.usuario',
                'intento.respuestas.pregunta',
            ])
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->whereNotNull(
                'evaluacion_uuid'
            )
            ->whereNotNull(
                'attempt_uuid'
            )
            ->whereHas(
                'evaluacion',
                function ($query) use ($moderatorUuid) {
                    $query->where(
                        'created_by',
                        $moderatorUuid
                    );
                }
            )
            ->whereHas(
                'intento',
                function ($query) use ($userUuid) {
                    $query
                        ->where(
                            'user_uuid',
                            $userUuid
                        )
                        ->where(
                            'status',
                            'COMPLETADA'
                        );
                }
            )
            ->orderBy(
                'created_at',
                'desc'
            )
            ->get();

        if ($notificaciones->isEmpty()) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | MARCAR COMO LEÍDAS
        |--------------------------------------------------------------------------
        |
        | Al entrar a los resultados de este usuario, las notificaciones
        | correspondientes dejan de considerarse pendientes.
        |
        */

        ModeratorNotification::where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->whereNotNull(
                'evaluacion_uuid'
            )
            ->whereNotNull(
                'attempt_uuid'
            )
            ->whereIn(
                'id',
                $notificaciones
                    ->pluck('id')
            )
            ->update([
                'read' => true,
            ]);

        /*
        |--------------------------------------------------------------------------
        | DATOS DEL USUARIO
        |--------------------------------------------------------------------------
        */

        $usuario = $notificaciones
            ->first()
            ->intento
            ?->usuario;

        /*
        |--------------------------------------------------------------------------
        | RESULTADOS ÚNICOS
        |--------------------------------------------------------------------------
        */

        $resultados = $notificaciones
            ->filter(function ($notificacion) {
                return $notificacion->evaluacion !== null &&
                    $notificacion->intento !== null &&
                    $notificacion->intento->status === 'COMPLETADA';
            })
            ->unique(function ($notificacion) {
                return $notificacion->attempt_uuid;
            })
            ->values();

        return view(
            'moderator.evaluation-results-user',
            compact(
                'usuario',
                'resultados'
            )
        );
    }

    /**
     * Formulario para crear una evaluación.
     */
    public function create()
    {
        return view(
            'moderator.evaluations.create'
        );
    }

    /**
     * Guardar una nueva evaluación.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:200',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:ACTIVA,INACTIVA',
            ],

            'questions' => [
                'required',
                'array',
                'min:1',
            ],

            'questions.*.question' => [
                'required',
                'string',
            ],

            'questions.*.question_type' => [
                'required',
                'string',
                'max:50',
            ],

            'questions.*.required' => [
                'nullable',
                'boolean',
            ],

            'questions.*.options' => [
                'nullable',
                'array',
            ],

            'questions.*.options.*' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);

        DB::transaction(function () use (
            $validated
        ) {

            $evaluacion = Evaluacion::create([
                'title' =>
                    $validated['title'],

                'description' =>
                    $validated['description'] ?? null,

                'status' =>
                    $validated['status'],

                'created_by' =>
                    Auth::user()->uuid,
            ]);

            foreach (
                $validated['questions']
                as $index => $question
            ) {

                $options = null;

                if (
                    isset($question['options']) &&
                    is_array($question['options'])
                ) {

                    $options = array_values(
                        array_filter(
                            $question['options'],
                            fn ($option) =>
                                $option !== null &&
                                trim($option) !== ''
                        )
                    );

                    if (
                        count($options) === 0
                    ) {
                        $options = null;
                    }
                }

                EvaluacionPregunta::create([
                    'evaluacion_uuid' =>
                        $evaluacion->uuid,

                    'question' =>
                        $question['question'],

                    'question_type' =>
                        $question['question_type'],

                    'options' =>
                        $options,

                    'question_order' =>
                        $index + 1,

                    'required' =>
                        isset($question['required'])
                            ? (bool) $question['required']
                            : false,
                ]);
            }
        });

        return redirect()
            ->route(
                'moderator.evaluations'
            )
            ->with(
                'success',
                'Evaluación creada correctamente.'
            );
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(string $uuid)
    {
        $moderatorUuid = Auth::user()->uuid;

        $evaluacion = Evaluacion::with(
                'preguntas'
            )
            ->where(
                'uuid',
                $uuid
            )
            ->where(
                'created_by',
                $moderatorUuid
            )
            ->firstOrFail();

        return view(
            'moderator.evaluations.edit',
            compact('evaluacion')
        );
    }

    /**
     * Actualizar evaluación.
     */
    public function update(
        Request $request,
        string $uuid
    ) {

        $moderatorUuid = Auth::user()->uuid;

        $evaluacion = Evaluacion::where(
                'uuid',
                $uuid
            )
            ->where(
                'created_by',
                $moderatorUuid
            )
            ->firstOrFail();

        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:200',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:ACTIVA,INACTIVA',
            ],

            'questions' => [
                'required',
                'array',
                'min:1',
            ],

            'questions.*.uuid' => [
                'nullable',
                'string',
                'exists:evaluacion_preguntas,uuid',
            ],

            'questions.*.question' => [
                'required',
                'string',
            ],

            'questions.*.question_type' => [
                'required',
                'string',
                'max:50',
            ],

            'questions.*.required' => [
                'nullable',
                'boolean',
            ],

            'questions.*.options' => [
                'nullable',
                'array',
            ],

            'questions.*.options.*' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $evaluacion
        ) {

            $evaluacion->update([
                'title' =>
                    $validated['title'],

                'description' =>
                    $validated['description'] ?? null,

                'status' =>
                    $validated['status'],
            ]);

            $preguntasEnviadas = collect(
                $validated['questions']
            )
                ->pluck('uuid')
                ->filter()
                ->values();

            $evaluacion
                ->preguntas()
                ->whereNotIn(
                    'uuid',
                    $preguntasEnviadas
                )
                ->delete();

            foreach (
                $validated['questions']
                as $index => $question
            ) {

                $options = null;

                if (
                    isset($question['options']) &&
                    is_array($question['options'])
                ) {

                    $options = array_values(
                        array_filter(
                            $question['options'],
                            fn ($option) =>
                                $option !== null &&
                                trim($option) !== ''
                        )
                    );

                    if (
                        count($options) === 0
                    ) {
                        $options = null;
                    }
                }

                if (
                    !empty($question['uuid'])
                ) {

                    $pregunta =
                        EvaluacionPregunta::where(
                            'uuid',
                            $question['uuid']
                        )
                        ->where(
                            'evaluacion_uuid',
                            $evaluacion->uuid
                        )
                        ->firstOrFail();

                    $pregunta->update([
                        'question' =>
                            $question['question'],

                        'question_type' =>
                            $question['question_type'],

                        'options' =>
                            $options,

                        'question_order' =>
                            $index + 1,

                        'required' =>
                            isset(
                                $question['required']
                            )
                                ? (bool) $question['required']
                                : false,
                    ]);

                } else {

                    EvaluacionPregunta::create([
                        'evaluacion_uuid' =>
                            $evaluacion->uuid,

                        'question' =>
                            $question['question'],

                        'question_type' =>
                            $question['question_type'],

                        'options' =>
                            $options,

                        'question_order' =>
                            $index + 1,

                        'required' =>
                            isset(
                                $question['required']
                            )
                                ? (bool) $question['required']
                                : false,
                    ]);
                }
            }
        });

        return redirect()
            ->route(
                'moderator.evaluations'
            )
            ->with(
                'success',
                'Evaluación actualizada correctamente.'
            );
    }

    /**
     * Eliminar una evaluación.
     */
    public function destroy(string $uuid)
    {
        $moderatorUuid = Auth::user()->uuid;

        $evaluacion = Evaluacion::where(
                'uuid',
                $uuid
            )
            ->where(
                'created_by',
                $moderatorUuid
            )
            ->firstOrFail();

        $evaluacion->delete();

        return redirect()
            ->route(
                'moderator.evaluations'
            )
            ->with(
                'success',
                'Evaluación eliminada correctamente.'
            );
    }
}
