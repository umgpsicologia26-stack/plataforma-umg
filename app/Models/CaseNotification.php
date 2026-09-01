<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseNotification extends Model
{
    protected $table = 'case_notifications';

    protected $fillable = [
        'user_uuid',
        'moderator_uuid',
        'case_id',
        'comment_id',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


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


    /* CASO */

    public function caseFile()
    {
        return $this->belongsTo(
            CaseFile::class,
            'case_id',
            'id'
        );
    }


    /* COMENTARIO */

    public function comment()
    {
        return $this->belongsTo(
            CaseComment::class,
            'comment_id',
            'id'
        );
    }
}