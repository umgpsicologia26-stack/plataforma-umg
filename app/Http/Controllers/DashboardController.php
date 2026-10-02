<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\CaseFile;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        //USUARIO NORMAL
                if ($user->role === 'USER') {
    
            $cases = CaseFile::where(
                'user_uuid',
                $user->uuid
            )
            ->latest()
            ->get();
    
            return view(
                'dashboard.home',
                compact('cases')
            );
        }


    //MODERADOR
        if ($user->role === 'MODERATOR') {

    return redirect()->route('moderator.dashboard');
}



        //ADMINISTRADOR
                if ($user->role === 'ADMIN') {

            $cases = CaseFile::where(
                'user_uuid',
                $user->uuid
            )
            ->latest()
            ->get();

            return view(
                'dashboard.home',
                compact('cases')
            );
        }


        //ROL NO RECONOCIDO
        
        Auth::logout();

        return redirect('/login')
            ->with(
                'error',
                'El rol de tu cuenta no es válido.'
            );
    }
}
