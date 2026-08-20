<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NicknameHistory extends Model
{
    protected $table = 'nickname_history';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'user_uuid',
        'old_nickname',
        'new_nickname',
        'changed_at'
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    /**
     * Usuario al que pertenece este nickname.
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