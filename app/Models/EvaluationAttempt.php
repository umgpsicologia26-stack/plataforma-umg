<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EvaluationAttempt extends Model
{
    protected $table = 'evaluation_attempts';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'evaluacion_uuid',
        'user_uuid',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($attempt) {
            if (empty($attempt->uuid)) {
                $attempt->uuid = (string) Str::uuid();
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

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
            'uuid'
        );
    }

    public function respuestas()
    {
        return $this->hasMany(
            EvaluacionRespuesta::class,
            'attempt_uuid',
            'uuid'
        );
    }
}