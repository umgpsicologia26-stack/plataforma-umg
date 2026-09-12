<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ModeratorController;
class CaseFile extends Model
{
    protected $table = 'case_files';

    protected $fillable = [

        'case_number',
        'type',
        'description',
        'user_uuid',
        'moderator_uuid',
        'status',
    ];

    protected $casts = [
        'description' => 'encrypted',
    ];

    public function comments()
    {
        return $this->hasMany(
            CaseComment::class,
            'case_id'
        );
    }

    public function moderator()
    {
        return $this->belongsTo(
            User::class,
            'moderator_uuid',
            'uuid'
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