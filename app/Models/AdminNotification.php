<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = [
        'case_id',
        'user_uuid',
        'message',
        'read'
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function caseFile()
    {
        return $this->belongsTo(
            CaseFile::class,
            'case_id',
            'id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
            'uuid'
        );
    }
}