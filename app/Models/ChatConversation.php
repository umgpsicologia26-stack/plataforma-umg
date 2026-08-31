<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatConversation extends Model
{
    protected $table = 'chat_conversations';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'moderator_uuid',
        'status',
        'moderator_last_read_at',
    ];

    protected $casts = [
        'moderator_last_read_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($conversation) {

            if (empty($conversation->uuid)) {

                $conversation->uuid = (string) Str::uuid();

            }

        });
    }


    /* USUARIO */

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
            'uuid'
        );
    }


    /* MODERADOR */

    public function moderator()
    {
        return $this->belongsTo(
            User::class,
            'moderator_uuid',
            'uuid'
        );
    }

    /* MENSAJES */
    public function messages()
    {
        return $this->hasMany(
            ChatMessage::class,
            'conversation_id',
            'id'
        );
    }


    /* NOTIFICACIONES DEL MODERADOR */

    public function moderatorNotifications()
    {
        return $this->hasMany(
            ModeratorNotification::class,
            'conversation_id',
            'id'
        );
    }


    /*MENSAJES DEL USUARIO */

    public function userMessages()
    {
        return $this->hasMany(
            ChatMessage::class,
            'conversation_id',
            'id'
        )->where(
            'sender_type',
            'USER'
        );
    }
}