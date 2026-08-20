<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
            'mensaje' => 'required'
        ]);

        // Aquí luego guardaremos o enviaremos el correo.

        return back()->with('success','Mensaje enviado correctamente.');
    }
}