<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseComment extends Model
{
    protected $fillable = [

        'case_id',
        'user_id',
        'comment',
        'color'

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
            'user_id',
            'uuid'
        );
    }
}