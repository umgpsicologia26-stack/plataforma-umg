<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrisisReport extends Model
{
    protected $table = 'crisis_reports';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'report_type',
        'description',
        'emergency_level',
        'status',
        'assigned_to'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
            'uuid'
        );
    }
}