<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CaseComment;
use App\Models\NicknameHistory;
use App\Models\CaseFile;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\ModeratorNotification;

class User extends Authenticatable
{
    use SoftDeletes;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'uuid',
        'firebase_uid',
        'first_name',
        'last_name',
        'email',
        'password_hash',
        'anonymous_nickname',
        'provider',
        'phone',
        'birth_date',
        'profile_image',
        'status',
        'role',
        'must_change_password',     
    ];

    protected $hidden = ['password_hash'];
    
    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAuthIdentifierName()
{
    return 'uuid';
}

    //CAST ROLE EN MAYÚSCULA CONSISTENTE
    public function getRoleAttribute($value)
    {
        return strtoupper($value);
    }

    //COMENTARIOS DE CASOS
    public function comments()
{
    return $this->hasMany(
        CaseComment::class,
        'user_id',
        'uuid'
    );
}

    public function nicknameHistory()
{
    return $this->hasMany(
        NicknameHistory::class,
        'user_uuid',
        'uuid'
    );
}

    //CASOS CREADOS POR EL USUARIO
    public function cases()
    {
        return $this->hasMany(
            CaseFile::class,
            'user_uuid',
            'uuid'
        );
    }

    //CASOS ASIGNADOS COMO MODERADOR
    public function moderatedCases()
    {
        return $this->hasMany(
            CaseFile::class,
            'moderator_uuid',
            'uuid'
        );
    }

    //CHATS COMO USUARIO

public function chatConversations()
{
    return $this->hasMany(
        ChatConversation::class,
        'user_uuid',
        'uuid'
    );
}

    //CHATS COMO MODERADOR

public function moderatedChatConversations()
{
    return $this->hasMany(
        ChatConversation::class,
        'moderator_uuid',
        'uuid'
    );
}


    //MENSAJES ENVIADOS

public function chatMessages()
{
    return $this->hasMany(
        ChatMessage::class,
        'sender_uuid',
        'uuid'
    );
}


    //NOTIFICACIONES COMO MODERADOR

public function moderatorNotifications()
{
    return $this->hasMany(
        ModeratorNotification::class,
        'moderator_uuid',
        'uuid'
    );
}
}
