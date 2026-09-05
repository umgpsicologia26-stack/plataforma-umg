<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NicknameHistory extends Model
{
    protected $table = 'nickname_history';

    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'user_uuid',
        'old_nickname',
        'new_nickname',
        'changed_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($history) {
            if (!$history->uuid) {
                $history->uuid = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}