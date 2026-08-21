<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CaseFile;
use App\Models\SystemSetting;
use App\Models\AdminNotification;
use App\Models\CaseComment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

//DASHBOARD ADMINISTRATIVO

    public function dashboard()
    {
        $moderators = User::where('role', 'MODERATOR')->get();

        $cases = CaseFile::with([
            'user',
            'moderator'
        ])
        ->latest()
        ->get();

        return view(
            'admin.dashboard',
            compact('moderators', 'cases')
        );
    }

    //LISTADO DE CASOS

    public function cases()
    {
        $cases = CaseFile::with([
            'user',
            'moderator'
        ])
        ->latest()
        ->get();

        return view(
            'admin.cases',
            compact('cases')
        );
    }

    //VER CASO
    
    public function viewCase($id)
    {
        $case = CaseFile::with([
            'user',
            'moderator'
        ])->findOrFail($id);

        $comments = CaseComment::with('user')
            ->where('case_id', $case->id)
            ->latest()
            ->get();

        $notifications = AdminNotification::latest()
            ->take(10)
            ->get();

        return view(
            'admin.view-case',
            compact(
                'case',
                'comments',
                'notifications'
            )
        );
    }

    //CREAR MODERADOR
    
    public function createModerator(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8',
            'phone'      => 'required|string|max:20',
        ]);

        User::create([

            'uuid' => (string) Str::uuid(),

            'firebase_uid' => (string) Str::uuid(),

            'first_name' => $request->first_name,

            'last_name' => $request->last_name,

            'email' => $request->email,

            'provider' => 'EMAIL',

            'password_hash' => Hash::make(
                $request->password
            ),

            'role' => 'MODERATOR',

            'phone' => $request->phone,

            'anonymous_nickname' =>
                $this->generateUniqueCode(),

            'status' => 'ACTIVE',
            'must_change_password' => true,
        ]);

        return back()->with(
            'success',
            'Moderador creado correctamente'
        );
    }

    //ELIMINAR MODERADOR

    public function deleteModerator($id)
    {
        $moderator = User::where(
            'role',
            'MODERATOR'
        )->findOrFail($id);

        $moderator->delete();

        return back()->with(
            'success',
            'Moderador eliminado'
        );
    }

    //RESTAURAR MODERADOR
    
    public function restoreModerator($id)
    {
        $moderator = User::withTrashed()
            ->where(
                'role',
                'MODERATOR'
            )
            ->findOrFail($id);

        $moderator->restore();

        $moderator->status = 'ACTIVE';

        $moderator->save();

        return back()->with(
            'success',
            'Moderador restaurado correctamente'
        );
    }

    //ACTUALIZAR CASO
    
    public function updateCase(
        Request $request,
        $id
    ) {
        $request->validate([
            'status' =>
                'required|in:ABIERTO,EN_PROCESO,TERMINADO,PENDIENTE_APROBACION,CERRADO'
        ]);

        $case = CaseFile::findOrFail($id);

        $case->status = $request->status;

        $case->save();

        AdminNotification::create([
            'message' =>
                'Se actualizó el estado del caso '
                . $case->case_number
        ]);

        return back()->with(
            'success',
            'Caso actualizado correctamente'
        );
    }

    //VERIFICAR ADMINISTRADOR
    
    public function verifyAdmin(Request $request)
    {

        //Verificar sesión
        
        if (!Auth::check()) {
            return redirect('/login')
                ->with(
                    'error',
                    'Debes iniciar sesión.'
                );
        }

        //Obtener usuario autenticado

        $user = Auth::user();

        //Verificar que sea ADMIN
        

        if ($user->role !== 'ADMIN') {
            return redirect('/dashboard')
                ->with(
                    'error',
                    'No tienes permisos para acceder al área administrativa.'
                );
        }

        //Validar contraseña

        $request->validate([
            'password' => 'required|string'
        ]);

        //Comparar contraseña con password_hash
        
        if (!Hash::check(
            $request->password,
            $user->password_hash
        )) {

            return back()->with(
                'error',
                'Contraseña de administrador incorrecta.'
            );
        }

        // Marcar acceso administrativo como verificado

        session([
    'admin_verified' => true,
    'admin_verified_user' => $user->uuid,
]);

        //Entrar al panel

        return redirect('/admin-panel');
    }

    //NOTIFICACIONES

public function notifications()
{
    $notifications = AdminNotification::latest()
        ->get();

    return view(
        'admin.notifications',
        compact('notifications')
    );
}

    //MARCAR NOTIFICACIÓN COMO LEÍDA

public function markNotificationAsRead($id)
{
    $notification = AdminNotification::findOrFail($id);
    $notification->read = 1;
    $notification->save();
    return back();
}

    //MODERADORES

    public function moderators()
    {
        $moderators = User::where(
            'role',
            'MODERATOR'
        )
        ->latest()
        ->get();

        return view(
            'admin.moderators',
            compact('moderators')
        );
    }

    //REPORTES
    
    public function reports()
    {
        $openCases = CaseFile::where(
            'status',
            'ABIERTO'
        )->count();

        $closedCases = CaseFile::where(
            'status',
            'CERRADO'
        )->count();

        $pendingCases = CaseFile::where(
            'status',
            'PENDIENTE_APROBACION'
        )->count();

        //USUARIOS

        $usersCount = User::where(
            'role',
            'USER'
        )->count();

        $moderatorsCount = User::where(
            'role',
            'MODERATOR'
        )
        ->where(
            'status',
            'ACTIVE'
        )
        ->count();

    //CASOS POR MES
        
        $monthlyCases = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyCases[] =
                CaseFile::whereMonth(
                    'created_at',
                    $month
                )->count();
        }

        return view(
            'admin.reports',
            compact(
                'openCases',
                'closedCases',
                'pendingCases',
                'usersCount',
                'moderatorsCount',
                'monthlyCases'
            )
        );
    }

    //EXPORTAR EXCEL

    public function exportExcel()
    {
        $cases = CaseFile::with([
        'user',
        'moderator'
    ])
    ->latest()
    ->get();
    return response()->streamDownload(function () use ($cases) {
        $handle = fopen('php://output', 'w');

    //Permite que Excel reconozca correctamente los caracteres UTF-8
        fprintf(
            $handle,
            chr(0xEF) . chr(0xBB) . chr(0xBF)
        );

    //ENCABEZADOS
        fputcsv($handle, [
            'Número de Caso',
            'Tipo',
            'Descripción',
            'Estado',
            'Usuario',
            'Moderador',
            'Fecha'
        ]);

    //DATOS

        foreach ($cases as $case) {
            fputcsv($handle, [
                $case->case_number,
                $case->type,
                $case->description,
                $case->status,
                $case->user
                    ? $case->user->full_name
                    : 'No asignado',

                $case->moderator
                    ? $case->moderator->full_name
                    : 'No asignado',

                $case->created_at
                    ? $case->created_at->format('d/m/Y H:i')
                    : ''
            ]);
        }
        fclose($handle);
    }, 'reporte_casos.csv', [
        'Content-Type' => 'text/csv; charset=UTF-8',
    ]);
}
    //USUARIOS
    
    public function users()
    {
        $users = User::where(
            'role',
            'USER'
        )
        ->latest()
        ->get();

        return view(
            'admin.users',
            compact('users')
        );
    }

    //ACTIVAR USUARIO
    
    public function activateUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'ACTIVE';
        $user->save();

        return back()->with(
            'success',
            'Usuario activado correctamente'
        );
    }

    //SUSPENDER USUARIO
    
    public function suspendUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'BLOCKED';
        $user->save();

        return back()->with(
            'success',
            'Usuario bloqueado correctamente'
        );
    }

    //ELIMINAR USUARIO
    
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with(
            'success',
            'Usuario eliminado correctamente'
        );
    }

    //RESTAURAR USUARIO

    public function restoreUser($id)
    {
        $user = User::withTrashed()
            ->findOrFail($id);
        $user->restore();
        $user->status = 'ACTIVE';
        $user->save();

        return back()->with(
            'success',
            'Usuario restaurado correctamente'
        );
    }

    //CONFIGURACIÓN
    
    public function configuration()
    {
        $settings = SystemSetting::firstOrCreate(
    ['id' => 1],
    [
        'system_name' => 'UMG',
        'forum_enabled' => true,
        'panic_enabled' => true,
        'registration_enabled' => true,
        'case_creation_enabled' => true,
        'maintenance_mode' => false
    ]
);

        return view(
            'admin.configuration',
            compact('settings')
        );
    }

    //GUARDAR CONFIGURACIÓN

    public function saveConfiguration(Request $request)
    {
        $request->validate([
        'system_name' => 'required|string|max:255',
    ]);

    $settings = SystemSetting::first();
    if (!$settings) {
        $settings = new SystemSetting();
        $settings->id = 1;
    }

    $settings->system_name = $request->system_name;
    $settings->forum_enabled =
        $request->has('forum_enabled');
    $settings->panic_enabled =
        $request->has('panic_enabled');
    $settings->registration_enabled =
        $request->has('registration_enabled');
    $settings->case_creation_enabled =
        $request->has('case_creation_enabled');
    $settings->maintenance_mode =
        $request->has('maintenance_mode');
    $settings->save();

    return back()->with(
        'success',
        'Configuración actualizada correctamente.'
    );
}

    //GENERAR NICKNAME ANÓNIMO
    
    private function generateUniqueCode()
    {
        do {
            $code = strtoupper(
                Str::random(8)
            );

        } while (
            User::where(
                'anonymous_nickname',
                $code
            )->exists()
        );

        return $code;
    }

    //PANEL ADMINISTRATIVO

    public function panel()
    {
        $notifications = AdminNotification::orderBy(
        'created_at',
        'desc'
    )->limit(10)
    ->get();

    $unreadNotifications = AdminNotification::where('read', 0)
    ->count();

    $cases = CaseFile::with('moderator')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.panel', compact(
        'notifications',
        'unreadNotifications',
        'cases'
    ));
}

    //EDITAR CASO
    
    public function editCase($id)
    {
        $case = CaseFile::with([
            'user',
            'moderator'
        ])->findOrFail($id);

        return view(
            'admin.edit-case',
            compact('case')
        );
    }

    //ELIMINAR CASO
    
    public function deleteCase($id)
    {
        $case = CaseFile::findOrFail($id);
        $case->delete();

        return redirect(
            '/admin/cases'
        )->with(
            'success',
            'Caso eliminado correctamente'
        );
    }

    //APROBAR CASO
    
    public function approveCase($id)
    {
        $case = CaseFile::findOrFail($id);
        $case->status = 'CERRADO';
        $case->admin_approved = true;
        $case->save();

        AdminNotification::create([
            'message' =>
                'El caso '
                . $case->case_number
                . ' fue aprobado por el administrador.'
        ]);

        return back()->with(
            'success',
            'Caso confirmado como terminado'
        );
    }

    //FINALIZAR CASO
    
    public function finishCase($id)
    {
        $case = CaseFile::findOrFail($id);
        $case->status =
            'PENDIENTE_APROBACION';
        $case->save();

        AdminNotification::create([
            'message' =>
                'El caso '
                . $case->case_number
                . ' quedó pendiente de aprobación.'
        ]);

        return back()->with(
            'success',
            'Caso enviado a aprobación'
        );
    }

    //AGREGAR COMENTARIO A CASO
    
    public function saveComment(
    Request $request,
    $id
    )
    
    {
    $request->validate([
        'comment' => 'required|string',
        'color' => 'nullable|string|max:50'
    ]);

    $case = CaseFile::findOrFail($id);
    $user = Auth::user();

    if (!$user) {
        return back()->with(
            'error',
            'Debe iniciar sesión para agregar una observación.'
        );
    }

    //Solo el ADMINISTRADOR puede crear observaciones
    
    if ($user->role !== 'ADMIN') {
        return back()->with(
            'error',
            'Solo el administrador puede agregar observaciones.'
        );
    }

    //Guardar observación
    
    CaseComment::create([
        'case_id' => $case->id,
        'user_id' => $user->uuid,
        'type' => 'OBSERVACION',
        'comment' => $request->comment,
        'color' => $request->color
    ]);

    //Notificar al moderador
    
    return back()->with(
        'success',
        'Observación agregada correctamente.'
    );
}   
}