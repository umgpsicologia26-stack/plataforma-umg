<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'system_name',
        'admin_password',
        'forum_enabled',
        'panic_enabled',
        'case_creation_enabled',
        'maintenance_mode',
        'registration_enabled'
    ];
}
