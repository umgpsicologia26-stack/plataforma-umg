<?php

namespace App\Http\Controllers;

use App\Models\CaseFile;
use App\Models\CaseComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeratorController extends BaseController
{
    public function dashboard()
    {
        return view('moderator.dashboard');
    }
    
    /*
    |--------------------------------------------------------------------------
    | LISTAR CASOS ASIGNADOS
    |--------------------------------------------------------------------------
    */

    public function cases()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $cases = CaseFile::where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->with([
                'user',
                'comments.user'
            ])
            ->latest()
            ->get();

        return view(
            'moderator.cases',
            compact('cases')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VER CASO INDIVIDUAL
    |--------------------------------------------------------------------------
    */

    public function viewCase($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        /*
        |--------------------------------------------------------------------------
        | SEGURIDAD
        |--------------------------------------------------------------------------
        | El moderador únicamente puede consultar
        | casos que le fueron asignados.
        |--------------------------------------------------------------------------
        */

        $case = CaseFile::where('id', $id)
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->with([
                'user',
                'moderator',
                'comments.user'
            ])
            ->firstOrFail();

        return view(
            'moderator.view-case',
            compact('case')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | AGREGAR OBSERVACIÓN / CORRECCIÓN
    |--------------------------------------------------------------------------
    */

    public function saveComment(
        Request $request,
        $id
    ) {
        $this->checkRole(['MODERATOR']);

        $request->validate([
            'type' => [
                'required',
                'in:OBSERVACION,CORRECCION'
            ],

            'comment' => [
                'required',
                'string',
                'min:3',
                'max:5000'
            ]
        ]);

        $moderatorUuid = Auth::user()->uuid;

        /*
        |--------------------------------------------------------------------------
        | Verificar que el caso pertenece al moderador
        |--------------------------------------------------------------------------
        */

        $case = CaseFile::where('id', $id)
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Guardar seguimiento
        |--------------------------------------------------------------------------
        */

        CaseComment::create([
            'case_id' => $case->id,
            'user_id' => $moderatorUuid,
            'type' => $request->type,
            'comment' => $request->comment,
            'color' => null
        ]);


        /*
        |--------------------------------------------------------------------------
        | Cambiar automáticamente a seguimiento
        |--------------------------------------------------------------------------
        */

        if ($case->status === 'ABIERTO') {

            $case->status = 'En seguimiento';

            $case->save();
        }


        return back()->with(
            'success',
            'Seguimiento guardado correctamente.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ESTADO
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        Request $request,
        $id
    ) {
        $this->checkRole(['MODERATOR']);

        $request->validate([
            'status' => [
                'required',
                'in:ABIERTO,En seguimiento,Atendido,Cerrado'
            ]
        ]);

        $moderatorUuid = Auth::user()->uuid;

        $case = CaseFile::where('id', $id)
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->firstOrFail();


        $case->update([
            'status' => $request->status
        ]);


        return back()->with(
            'success',
            'Estado del caso actualizado correctamente.'
        );
    }
}