<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatMessage extends Model
{
    protected $table = 'chat_messages';

    protected $fillable = [
        'uuid',
        'conversation_id',
        'sender_uuid',
        'sender_type',
        'message',
    ];

    protected $casts = [
    'message' => 'encrypted',
];

    protected static function booted()
    {
        static::creating(function ($chatMessage) {

            if (empty($chatMessage->uuid)) {

                $chatMessage->uuid = (string) Str::uuid();

            }

        });
    }


    /* CONVERSACIÓN */

    public function conversation()
    {
        return $this->belongsTo(
            ChatConversation::class,
            'conversation_id',
            'id'
        );
    }


    /* REMITENTE */

    public function sender()
    {
        return $this->belongsTo(
            User::class,
            'sender_uuid',
            'uuid'
        );
    }
}