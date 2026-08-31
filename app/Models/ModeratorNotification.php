<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeratorNotification extends Model
{
    protected $table = 'moderator_notifications';

    protected $fillable = [
        'moderator_uuid',
        'conversation_id',
        'message',
        'read',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    //MODERADOR
    
    public function moderator()
    {
        return $this->belongsTo(
            User::class,
            'moderator_uuid',
            'uuid'
        );
    }

    //CONVERSACIÓN
    
    public function conversation()
    {
        return $this->belongsTo(
            ChatConversation::class,
            'conversation_id',
            'id'
        );
    }
}