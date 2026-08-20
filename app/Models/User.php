<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        
        'uuid',
        'firebase_uid',
        'first_name',
        'last_name',
        'email',
        'password_hash',
        'anonymous_nickname',
        'provider',
        'phone',
        'birth_date',
        'profile_image',
        'status',
        'role',
        'must_change_password',     
    ];

    protected $hidden = ['password_hash'];
    
    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
public function getAuthIdentifierName()
{
    return 'uuid';
}
    //CAST ROLE EN MAYÚSCULA CONSISTENTE
    public function getRoleAttribute($value)
    {
        return strtoupper($value);
    }

    //COMENTARIOS DE CASOS
    public function comments()
{
    return $this->hasMany(
        CaseComment::class,
        'user_id',
        'uuid'
    );
}

public function nicknameHistory()
{
    return $this->hasMany(
        NicknameHistory::class,
        'user_uuid',
        'uuid'
    );
}

/*
    |--------------------------------------------------------------------------
    | CASOS CREADOS POR EL USUARIO
    |--------------------------------------------------------------------------
    |
    | case_files.user_uuid → users.uuid
    |
    */

    public function cases()
    {
        return $this->hasMany(
            CaseFile::class,
            'user_uuid',
            'uuid'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CASOS ASIGNADOS COMO MODERADOR
    |--------------------------------------------------------------------------
    |
    | case_files.moderator_uuid → users.uuid
    |
    */

    public function moderatedCases()
    {
        return $this->hasMany(
            CaseFile::class,
            'moderator_uuid',
            'uuid'
        );
    }

// =========================
// MOSTRAR CAMBIO DE CONTRASEÑA
// =========================

public function showChangePassword()
{
    return view('auth.change-password');
}

// =========================
// CAMBIAR CONTRASEÑA
// =========================
public function changePassword(Request $request)
{
    $request->validate([
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed'
        ],
    ]);

    $user = Auth::user();

    $user->password_hash = Hash::make(
        $request->password
    );

    // Ya no debe obligarse al moderador
    // a cambiar la contraseña.
    $user->must_change_password = false;

    $user->save();

    $request->session()->regenerate();

    return redirect()
        ->route('dashboard')
        ->with(
            'success',
            'Contraseña actualizada correctamente.'
        );
}
}