<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'status',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($evaluacion) {
            if (empty($evaluacion->uuid)) {
                $evaluacion->uuid = (string) Str::uuid();
            }
        });
    }

    public function preguntas()
    {
        return $this->hasMany(
            EvaluacionPregunta::class,
            'evaluacion_uuid',
            'uuid'
        )->orderBy('question_order');
    }

    public function creador()
    {
        return $this->belongsTo(
            User::class,
            'created_by',
            'uuid'
        );
    }

    public function respuestas()
    {
        return $this->hasMany(
            EvaluacionRespuesta::class,
            'evaluacion_uuid',
            'uuid'
        );
    }

    public function intentos()
{
    return $this->hasMany(
        EvaluationAttempt::class,
        'evaluacion_uuid',
        'uuid'
    );
}

}