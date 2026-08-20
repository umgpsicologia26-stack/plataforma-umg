<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function checkRole($roles)
    {
        if (!Auth::check()) {
            abort(401);
        }

        if (!in_array(Auth::user()->role, (array) $roles)) {
            abort(403, 'No autorizado');
        }
    }
}