<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChange extends Model
{
    protected $fillable = [
        'user_id',
        'field_changed',
        'old_value',
        'new_value'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'uuid'
        );
    }
}