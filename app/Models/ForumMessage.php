<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumMessage extends Model
{
    protected $table = 'mensajes_foro';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'category',
        'content',
        'is_anonymous',
        'ai_flagged',
        'visibility_status'
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'ai_flagged' => 'boolean',
    ];

    /**
     * Usuario que creó el mensaje.
     *
     * mensajes_foro.user_uuid
     *        ↓
     * users.uuid
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
            'uuid'
        );
    }
}