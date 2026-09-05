<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeratorNotification extends Model
{
    protected $table = 'moderator_notifications';

    protected $fillable = [
        'moderator_uuid',
        'conversation_id',
        'evaluacion_uuid',
        'attempt_uuid',
        'message',
        'read',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function moderator()
    {
        return $this->belongsTo(
            User::class,
            'moderator_uuid',
            'uuid'
        );
    }

    public function conversation()
    {
        return $this->belongsTo(
            ChatConversation::class,
            'conversation_id',
            'id'
        );
    }

    public function evaluacion()
    {
        return $this->belongsTo(
            Evaluacion::class,
            'evaluacion_uuid',
            'uuid'
        );
    }

    public function intento()
    {
        return $this->belongsTo(
            EvaluationAttempt::class,
            'attempt_uuid',
            'uuid'
        );
    }
}