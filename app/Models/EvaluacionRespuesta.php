<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EvaluacionRespuesta extends Model
{
    protected $table = 'evaluacion_respuestas';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
    'uuid',
    'attempt_uuid',
    'evaluacion_uuid',
    'pregunta_uuid',
    'user_uuid',
    'respuesta',
    'completed_at',
];

    public function intento()
{
    return $this->belongsTo(
        EvaluationAttempt::class,
        'attempt_uuid',
        'uuid'
    );
}
    protected $casts = [
        'completed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($respuesta) {
            if (empty($respuesta->uuid)) {
                $respuesta->uuid = (string) Str::uuid();
            }
        });
    }

    public function evaluacion()
    {
        return $this->belongsTo(
            Evaluacion::class,
            'evaluacion_uuid',
            'uuid'
        );
    }

    public function pregunta()
    {
        return $this->belongsTo(
            EvaluacionPregunta::class,
            'pregunta_uuid',
            'uuid'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
            'uuid'
        );
    }
}