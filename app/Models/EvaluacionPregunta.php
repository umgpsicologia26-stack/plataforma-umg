<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EvaluacionPregunta extends Model
{
    protected $table = 'evaluacion_preguntas';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'evaluacion_uuid',
        'question',
        'question_type',
        'options',
        'question_order',
        'required',
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pregunta) {
            if (empty($pregunta->uuid)) {
                $pregunta->uuid = (string) Str::uuid();
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

    public function respuestas()
    {
        return $this->hasMany(
            EvaluacionRespuesta::class,
            'pregunta_uuid',
            'uuid'
        );
    }
}