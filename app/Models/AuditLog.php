<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'action',
        'performed_by',
        'target_user',
        'changes'
    ];

    public function performedBy()
    {
        return $this->belongsTo(
            User::class,
            'performed_by',
            'uuid'
        );
    }

    public function targetUser()
    {
        return $this->belongsTo(
            User::class,
            'target_user',
            'uuid'
        );
    }
}