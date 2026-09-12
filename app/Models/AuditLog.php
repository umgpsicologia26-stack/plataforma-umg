<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'action',
        'performed_by',
        'target_type',
        'target_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function performedBy()
    {
        return $this->belongsTo(
            User::class,
            'performed_by',
            'uuid'
        );
    }
}