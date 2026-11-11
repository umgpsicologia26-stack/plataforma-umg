<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Evaluacion;
use App\Models\EvaluacionPregunta;
use App\Models\EvaluacionRespuesta;
use App\Models\EvaluationAttempt;
use App\Models\ModeratorNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class EvaluacionSubmitTest extends TestCase
{
    use DatabaseTransactions;

    private function crearUsuario(string $role = 'USER'): User
    {
        return User::create([
            'uuid' => (string) Str::uuid(),
            'first_name' => 'Usuario',
            'last_name' => 'Prueba',
            'email' => Str::uuid() . '@vitasafe.test',
            'anonymous_nickname' => 'prueba_' . Str::uuid(),
            'provider' => 'EMAIL',
            'role' => $role,
            'status' => 'Activo',
        ]);
    }

    private function crearEvaluacion(?string $moderadorUuid = null): array
    {
        $evaluacion = Evaluacion::create([
            'uuid' => (string) Str::uuid(),
            'title' => 'EvaluaciÃ³n de prueba',
            'description' => 'EvaluaciÃ³n creada para pruebas automatizadas.',
            'status' => 'ACTIVA',
            'created_by' => $moderadorUuid,
        ]);

        $pregunta = EvaluacionPregunta::create([
            'uuid' => (string) Str::uuid(),
            'evaluacion_uuid' => $evaluacion->uuid,
            'question' => 'Â¿CÃ³mo te sientes actualmente?',
            'question_type' => 'OPCION_MULTIPLE',
            'options' => ['Bien', 'Regular', 'Mal'],
            'question_order' => 1,
            'required' => true,
        ]);

        return [$evaluacion, $pregunta];
    }

    public function test_usuario_puede_completar_una_evaluacion(): void
    {
        $usuario = $this->crearUsuario();

        [$evaluacion, $pregunta] = $this->crearEvaluacion();

        $this->actingAs($usuario)
            ->post(route('evaluation.submit', $evaluacion->uuid), [
                'respuestas' => [
                    $pregunta->uuid => 'Bien',
                ],
            ])
            ->assertRedirect(route('evaluation.index'))
            ->assertSessionHas('success');

        $intento = EvaluationAttempt::where(
            'evaluacion_uuid',
            $evaluacion->uuid
        )->where('user_uuid', $usuario->uuid)->firstOrFail();

        $this->assertSame('COMPLETADA', $intento->status);

        $respuesta = EvaluacionRespuesta::where(
            'attempt_uuid',
            $intento->uuid
        )->firstOrFail();

        $this->assertSame('Bien', $respuesta->respuesta);
    }

    public function test_no_permite_enviar_sin_responder_preguntas_obligatorias(): void
    {
        $usuario = $this->crearUsuario();

        [$evaluacion] = $this->crearEvaluacion();

        $this->actingAs($usuario)
            ->from(route('evaluation.show', $evaluacion->uuid))
            ->post(route('evaluation.submit', $evaluacion->uuid), [
                'respuestas' => [],
            ])
            ->assertRedirect(route('evaluation.show', $evaluacion->uuid))
            ->assertSessionHasErrors('respuestas');

        $this->assertSame(
            0,
            EvaluationAttempt::where(
                'evaluacion_uuid',
                $evaluacion->uuid
            )->where('user_uuid', $usuario->uuid)->count()
        );
    }

    public function test_no_permite_completar_dos_veces_la_misma_evaluacion(): void
    {
        $usuario = $this->crearUsuario();

        [$evaluacion, $pregunta] = $this->crearEvaluacion();

        EvaluationAttempt::create([
            'uuid' => (string) Str::uuid(),
            'evaluacion_uuid' => $evaluacion->uuid,
            'user_uuid' => $usuario->uuid,
            'status' => 'COMPLETADA',
            'started_at' => now(),
            'completed_at' => now(),
        ]);

        $this->actingAs($usuario)
            ->post(route('evaluation.submit', $evaluacion->uuid), [
                'respuestas' => [
                    $pregunta->uuid => 'Bien',
                ],
            ])
            ->assertRedirect(route('evaluation.index'))
            ->assertSessionHas('error');

        $this->assertSame(
            1,
            EvaluationAttempt::where(
                'evaluacion_uuid',
                $evaluacion->uuid
            )->where('user_uuid', $usuario->uuid)->count()
        );

        $this->assertSame(
            0,
            EvaluacionRespuesta::where(
                'evaluacion_uuid',
                $evaluacion->uuid
            )->where('user_uuid', $usuario->uuid)->count()
        );
    }

    public function test_registra_notificacion_al_moderador_al_completar_evaluacion(): void
    {
        $usuario = $this->crearUsuario();
        $moderador = $this->crearUsuario('MODERATOR');

        [$evaluacion, $pregunta] = $this->crearEvaluacion(
            $moderador->uuid
        );

        $this->actingAs($usuario)
            ->post(route('evaluation.submit', $evaluacion->uuid), [
                'respuestas' => [
                    $pregunta->uuid => 'Bien',
                ],
            ])
            ->assertRedirect(route('evaluation.index'))
            ->assertSessionHas('success');

        $intento = EvaluationAttempt::where(
            'evaluacion_uuid',
            $evaluacion->uuid
        )->where('user_uuid', $usuario->uuid)->firstOrFail();

        $notificacion = ModeratorNotification::where(
            'moderator_uuid',
            $moderador->uuid
        )->where('attempt_uuid', $intento->uuid)->firstOrFail();

        $this->assertSame($evaluacion->uuid, $notificacion->evaluacion_uuid);
        $this->assertNull($notificacion->conversation_id);
        $this->assertFalse($notificacion->read);
    }

    public function test_visitante_sin_sesion_no_puede_acceder_a_evaluaciones(): void
    {
        $this->get(route('evaluation.index'))
            ->assertRedirect('/login');
    }

    public function test_moderador_no_puede_acceder_a_evaluaciones_de_usuario(): void
    {
        $moderador = $this->crearUsuario('MODERATOR');

        $this->actingAs($moderador)
            ->get(route('evaluation.index'))
            ->assertRedirect('/dashboard')
            ->assertSessionHas('error');
    }

    public function test_usuario_no_puede_acceder_a_gestion_de_evaluaciones(): void
    {
        $usuario = $this->crearUsuario('USER');

        $this->actingAs($usuario)
            ->get(route('moderator.evaluations'))
            ->assertRedirect('/dashboard')
            ->assertSessionHas('error');
    }


    public function test_usuario_puede_acceder_a_lista_de_evaluaciones(): void
    {
        $usuario = $this->crearUsuario('USER');

        $this->actingAs($usuario)
            ->get(route('evaluation.index'))
            ->assertOk()
            ->assertViewIs('evaluations.index');
    }

    public function test_moderador_puede_acceder_a_gestion_de_evaluaciones(): void
    {
        $moderador = $this->crearUsuario('MODERATOR');

        [$evaluacion] = $this->crearEvaluacion($moderador->uuid);

        $this->actingAs($moderador)
            ->get(route('moderator.evaluations'))
            ->assertOk()
            ->assertViewIs('moderator.evaluations.index')
            ->assertViewHas('evaluaciones', function ($evaluaciones) use ($evaluacion) {
                return $evaluaciones->contains('uuid', $evaluacion->uuid);
            });
    }


    public function test_moderador_puede_consultar_resultados_de_su_evaluacion(): void
    {
        $moderador = $this->crearUsuario('MODERATOR');
        $usuario = $this->crearUsuario('USER');

        [$evaluacion] = $this->crearEvaluacion($moderador->uuid);

        $intento = EvaluationAttempt::create([
            'uuid' => (string) Str::uuid(),
            'evaluacion_uuid' => $evaluacion->uuid,
            'user_uuid' => $usuario->uuid,
            'status' => 'COMPLETADA',
            'started_at' => now(),
            'completed_at' => now(),
        ]);

        $notificacion = ModeratorNotification::create([
            'moderator_uuid' => $moderador->uuid,
            'conversation_id' => null,
            'evaluacion_uuid' => $evaluacion->uuid,
            'attempt_uuid' => $intento->uuid,
            'message' => 'EvaluaciÃ³n completada.',
            'read' => false,
        ]);

        $this->actingAs($moderador)
            ->get(route('moderator.evaluation-results.user', $usuario->uuid))
            ->assertOk()
            ->assertViewIs('moderator.evaluation-results-user');

        $this->assertTrue($notificacion->fresh()->read);
    }

    public function test_otro_moderador_no_puede_consultar_resultados_ajenos(): void
    {
        $moderadorPropietario = $this->crearUsuario('MODERATOR');
        $otroModerador = $this->crearUsuario('MODERATOR');
        $usuario = $this->crearUsuario('USER');

        [$evaluacion] = $this->crearEvaluacion(
            $moderadorPropietario->uuid
        );

        $intento = EvaluationAttempt::create([
            'uuid' => (string) Str::uuid(),
            'evaluacion_uuid' => $evaluacion->uuid,
            'user_uuid' => $usuario->uuid,
            'status' => 'COMPLETADA',
            'started_at' => now(),
            'completed_at' => now(),
        ]);

        ModeratorNotification::create([
            'moderator_uuid' => $moderadorPropietario->uuid,
            'conversation_id' => null,
            'evaluacion_uuid' => $evaluacion->uuid,
            'attempt_uuid' => $intento->uuid,
            'message' => 'EvaluaciÃ³n completada.',
            'read' => false,
        ]);

        $this->actingAs($otroModerador)
            ->get(route('moderator.evaluation-results.user', $usuario->uuid))
            ->assertNotFound();
    }

public function test_moderador_puede_crear_evaluacion_con_preguntas_y_auditoria(): void
{
    $moderador = $this->crearUsuario('MODERATOR');

    $datos = [
        'title' => 'EvaluaciÃ³n CRUD de prueba',
        'description' => 'DescripciÃ³n de prueba.',
        'status' => 'ACTIVA',
        'questions' => [
            [
                'question' => 'Â¿CÃ³mo te sientes?',
                'question_type' => 'OPCION_MULTIPLE',
                'required' => true,
                'options' => ['Bien', 'Regular', 'Mal'],
            ],
            [
                'question' => 'Â¿Deseas agregar algÃºn comentario?',
                'question_type' => 'TEXTO',
                'required' => false,
            ],
        ],
    ];

    $this->actingAs($moderador)
        ->post(route('moderator.evaluations.store'), $datos)
        ->assertRedirect(route('moderator.evaluations'))
        ->assertSessionHas('success');

    $evaluacion = \App\Models\Evaluacion::where(
        'title',
        'EvaluaciÃ³n CRUD de prueba'
    )->first();

    $this->assertNotNull($evaluacion);
    $this->assertSame($moderador->uuid, $evaluacion->created_by);
    $this->assertSame(2, $evaluacion->preguntas()->count());

    $this->assertDatabaseHas('audit_logs', [
        'action' => 'create_evaluation',
        'performed_by' => $moderador->uuid,
        'target_type' => 'Evaluacion',
        'target_id' => $evaluacion->uuid,
    ]);
}

public function test_moderador_no_puede_crear_evaluacion_sin_preguntas(): void
{
    $moderador = $this->crearUsuario('MODERATOR');

    $datos = [
        'title' => 'EvaluaciÃ³n sin preguntas',
        'description' => 'Prueba de validaciÃ³n.',
        'status' => 'ACTIVA',
        'questions' => [],
    ];

    $this->actingAs($moderador)
        ->post(route('moderator.evaluations.store'), $datos)
        ->assertSessionHasErrors('questions');

    $this->assertDatabaseMissing('evaluaciones', [
        'title' => 'EvaluaciÃ³n sin preguntas',
    ]);
}

public function test_moderador_puede_actualizar_evaluacion_y_sus_preguntas(): void
{
    $moderador = $this->crearUsuario('MODERATOR');

    [$evaluacion, $pregunta] = $this->crearEvaluacion($moderador->uuid);

    $datos = [
        'title' => 'EvaluaciÃ³n actualizada',
        'description' => 'DescripciÃ³n modificada.',
        'status' => 'INACTIVA',
        'questions' => [
            [
                'uuid' => $pregunta->uuid,
                'question' => 'Â¿CÃ³mo te encuentras hoy?',
                'question_type' => 'OPCION_MULTIPLE',
                'required' => true,
                'options' => ['Bien', 'Mal'],
            ],
            [
                'question' => 'Â¿Deseas agregar comentarios?',
                'question_type' => 'TEXTO',
                'required' => false,
            ],
        ],
    ];

    $this->actingAs($moderador)
        ->put(route('moderator.evaluations.update', $evaluacion->uuid), $datos)
        ->assertRedirect(route('moderator.evaluations'))
        ->assertSessionHas('success');

    $evaluacion->refresh();

    $this->assertSame('EvaluaciÃ³n actualizada', $evaluacion->title);
    $this->assertSame('INACTIVA', $evaluacion->status);
    $this->assertSame(2, $evaluacion->preguntas()->count());

    $this->assertDatabaseHas('evaluacion_preguntas', [
        'uuid' => $pregunta->uuid,
        'question' => 'Â¿CÃ³mo te encuentras hoy?',
    ]);

    $this->assertDatabaseHas('audit_logs', [
        'action' => 'update_evaluation',
        'performed_by' => $moderador->uuid,
        'target_type' => 'Evaluacion',
        'target_id' => $evaluacion->uuid,
    ]);
}

public function test_moderador_no_puede_asignar_preguntas_de_otra_evaluacion(): void
{
    $moderador = $this->crearUsuario('MODERATOR');

    [$evaluacionPropia] = $this->crearEvaluacion($moderador->uuid);
    [, $preguntaAjena] = $this->crearEvaluacion($moderador->uuid);

    $datos = [
        'title' => 'Intento de actualizaciÃ³n',
        'description' => 'Prueba de seguridad.',
        'status' => 'ACTIVA',
        'questions' => [
            [
                'uuid' => $preguntaAjena->uuid,
                'question' => 'Pregunta ajena',
                'question_type' => 'TEXTO',
                'required' => true,
            ],
        ],
    ];

    $this->actingAs($moderador)
        ->put(
            route('moderator.evaluations.update', $evaluacionPropia->uuid),
            $datos
        )
        ->assertNotFound();

    $this->assertDatabaseHas('evaluacion_preguntas', [
        'uuid' => $preguntaAjena->uuid,
        'evaluacion_uuid' => $preguntaAjena->evaluacion_uuid,
    ]);

    $this->assertDatabaseHas('evaluaciones', [
        'uuid' => $evaluacionPropia->uuid,
        'title' => 'EvaluaciÃ³n de prueba',
    ]);
}

public function test_moderador_puede_eliminar_evaluacion_y_registrar_auditoria(): void
{
    $moderador = $this->crearUsuario('MODERATOR');

    [$evaluacion, $pregunta] = $this->crearEvaluacion($moderador->uuid);

    $evaluacionUuid = $evaluacion->uuid;
    $preguntaUuid = $pregunta->uuid;

    $this->actingAs($moderador)
        ->delete(route('moderator.evaluations.destroy', $evaluacionUuid))
        ->assertRedirect(route('moderator.evaluations'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('evaluaciones', [
        'uuid' => $evaluacionUuid,
    ]);

    $this->assertDatabaseMissing('evaluacion_preguntas', [
        'uuid' => $preguntaUuid,
    ]);

    $this->assertDatabaseHas('audit_logs', [
        'action' => 'delete_evaluation',
        'performed_by' => $moderador->uuid,
        'target_type' => 'Evaluacion',
        'target_id' => $evaluacionUuid,
    ]);
}

public function test_moderador_no_puede_eliminar_evaluacion_ajena(): void
{
    $propietario = $this->crearUsuario('MODERATOR');
    $otroModerador = $this->crearUsuario('MODERATOR');

    [$evaluacion] = $this->crearEvaluacion($propietario->uuid);

    $this->actingAs($otroModerador)
        ->delete(route('moderator.evaluations.destroy', $evaluacion->uuid))
        ->assertNotFound();

    $this->assertDatabaseHas('evaluaciones', [
        'uuid' => $evaluacion->uuid,
        'created_by' => $propietario->uuid,
    ]);

    $this->assertDatabaseMissing('audit_logs', [
        'action' => 'delete_evaluation',
        'performed_by' => $otroModerador->uuid,
        'target_type' => 'Evaluacion',
        'target_id' => $evaluacion->uuid,
    ]);
}

public function test_moderador_puede_editar_su_evaluacion(): void
{
    $moderador = $this->crearUsuario('MODERATOR');

    [$evaluacion] = $this->crearEvaluacion($moderador->uuid);

    $this->actingAs($moderador)
        ->get(route('moderator.evaluations.edit', $evaluacion->uuid))
        ->assertOk()
        ->assertViewIs('moderator.evaluations.edit')
        ->assertViewHas('evaluacion', function ($resultado) use ($evaluacion) {
            return $resultado->uuid === $evaluacion->uuid;
        });
}

public function test_moderador_no_puede_editar_ni_actualizar_evaluacion_ajena(): void
{
    $propietario = $this->crearUsuario('MODERATOR');
    $otroModerador = $this->crearUsuario('MODERATOR');

    [$evaluacion] = $this->crearEvaluacion($propietario->uuid);

    $this->actingAs($otroModerador)
        ->get(route('moderator.evaluations.edit', $evaluacion->uuid))
        ->assertNotFound();

    $datos = [
        'title' => 'Intento de modificaciÃ³n',
        'description' => 'Prueba de seguridad.',
        'status' => 'INACTIVA',
        'questions' => [
            [
                'question' => 'Pregunta de prueba',
                'question_type' => 'TEXTO',
                'required' => true,
            ],
        ],
    ];

    $this->put(
        route('moderator.evaluations.update', $evaluacion->uuid),
        $datos
    )->assertNotFound();

    $this->assertDatabaseHas('evaluaciones', [
        'uuid' => $evaluacion->uuid,
        'title' => 'EvaluaciÃ³n de prueba',
        'created_by' => $propietario->uuid,
    ]);
}
}