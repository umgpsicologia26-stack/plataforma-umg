<?php

use Illuminate\Support\Facades\Auth;

function hasRole($role)
{
    return Auth::check() && Auth::user()->role === $role;
}

function hasAnyRole($roles)
{
    return Auth::check() && in_array(Auth::user()->role, $roles);
}

function currentUser()
{
    return Auth::user();
}

function currentUserUuid()
{
    return Auth::user()?->uuid;
}