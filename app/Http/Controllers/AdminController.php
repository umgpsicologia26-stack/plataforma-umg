<?php 
namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use App\Models\User; 
use App\Models\CaseFile; 
use App\Models\SystemSetting; 
use App\Models\AdminNotification; 
use App\Models\CaseComment; 
use App\Models\AuditLog; 
use App\Exports\ReporteCasosExport;
use Barryvdh\DomPDF\Facade\Pdf; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon; 

class AdminController extends Controller 
{ 
    // DASHBOARD ADMINISTRATIVO 
    public function dashboard() 
    { 
        $moderators = User::where( 
            'role', 
            'MODERATOR' 
        )->get(); 

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

    // LISTADO DE CASOS 
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

    // VER CASO 
    public function viewCase($id) 
    { 
        $case = CaseFile::with([ 
            'user', 
            'moderator' 
        ])->findOrFail($id); 

            $this->authorize('view', $case); 

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

    // CREAR MODERADOR 
    public function createModerator(Request $request) 
    { 
        $request->validate([ 
            'first_name' => 'required|string|max:150', 
            'last_name' => 'required|string|max:100', 
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:8', 
            'phone' => 'required|string|max:20', 
        ]); 

        $moderator = User::create([ 
            'uuid' => (string) Str::uuid(), 
            'firebase_uid' => (string) Str::uuid(), 
            'first_name' => $request->first_name, 
            'last_name' => $request->last_name, 
            'email' => $request->email, 
            'provider' => 'EMAIL', 
            'password_hash' => Hash::make($request->password), 
            'role' => 'MODERATOR', 
            'phone' => $request->phone, 
            'anonymous_nickname' => $this->generateUniqueCode(), 
            'status' => 'Activo', 
            'must_change_password' => true, 
        ]); 

        // REGISTRAR AUDITORÍA 

        AuditLog::create([ 
            'action' => 'create_moderator', 
            'performed_by' => Auth::user()->uuid, 
            'target_type' => 'User', 
            'target_id' => $moderator->uuid, 
            'changes' => [ 
                'created_fields' => [ 
                    'first_name' => $moderator->first_name, 
                    'last_name' => $moderator->last_name, 
                    'email' => $moderator->email, 
                    'role' => $moderator->role, 
                    'phone' => $moderator->phone, 
                    'status' => $moderator->status, 
                ], 
            ], 
        ]); 

        return back()->with( 
            'success', 
            'Moderador creado correctamente' 
        ); 
    } 

    // ELIMINAR MODERADOR 
    public function deleteModerator($id) 
    { 
        $moderator = User::where( 
            'role', 
            'MODERATOR' 
        )->findOrFail($id); 

        $moderatorUuid = $moderator->uuid; 
        $moderatorStatus = $moderator->status; 

        $moderator->delete(); 

        // REGISTRAR AUDITORÍA 

        AuditLog::create([ 
            'action' => 'delete_moderator', 
            'performed_by' => Auth::user()->uuid, 
            'target_type' => 'User', 
            'target_id' => $moderatorUuid, 
            'changes' => [ 
                'status' => [ 
                    'before' => $moderatorStatus, 
                    'after' => 'DELETED', 
                ], 
            ], 
        ]); 

        return back()->with( 
            'success', 
            'Moderador eliminado' 
        ); 
    } 

    // RESTAURAR MODERADOR 
    public function restoreModerator($id) 
    { 
        $moderator = User::withTrashed() 
            ->where( 
                'role', 
                'MODERATOR' 
            ) 
            ->findOrFail($id); 

        $moderator->restore(); 

        $moderator->status = 'Activo'; 

        $moderator->save(); 

        // REGISTRAR AUDITORÍA 

        AuditLog::create([ 
            'action' => 'restore_moderator', 
            'performed_by' => Auth::user()->uuid, 
            'target_type' => 'User', 
            'target_id' => $moderator->uuid, 
            'changes' => [ 
                'status' => [ 
                    'before' => 'DELETED', 
                    'after' => 'Activo', 
                ], 
            ], 
        ]); 

        return back()->with( 
            'success', 
            'Moderador restaurado correctamente' 
        ); 
    } 

    // ACTUALIZAR CASO 

public function updateCase( 
    Request $request, 
    $id 
) { 
    $request->validate([ 
        'status' => 'required|in:Abierto,En seguimiento,Cerrado', 
    ]); 

    $case = CaseFile::findOrFail($id); 

    $this->authorize('update', $case); 

    $oldStatus = $case->status; 

    $case->status = $request->status; 

    $case->save(); 

    // REGISTRAR AUDITORÍA SOLAMENTE SI CAMBIÓ EL ESTADO 

    if ($oldStatus !== $case->status) { 

        AuditLog::create([ 
            'action' => 'admin_update_case_status', 
            'performed_by' => Auth::user()->uuid, 
            'target_type' => 'CaseFile', 
            'target_id' => (string) $case->id, 
            'changes' => [ 
                'case_number' => $case->case_number, 
                'type' => $case->type, 
                'status' => [ 
                    'before' => $oldStatus, 
                    'after' => $case->status, 
                ], 
            ], 
        ]); 
    } 

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

    // VERIFICAR ADMINISTRADOR 

    public function verifyAdmin(Request $request) 
    { 
        // Verificar sesión 

        if (!Auth::check()) { 
            return redirect('/login') 
                ->with( 
                    'error', 
                    'Debes iniciar sesión.' 
                ); 
        } 

        // Obtener usuario autenticado 

        $user = Auth::user(); 

        // Verificar que sea ADMIN 

        if ($user->role !== 'ADMIN') { 
            return redirect('/dashboard') 
                ->with( 
                    'error', 
                    'No tienes permisos para acceder al área administrativa.' 
                ); 
        } 

        // Validar contraseña 

        $request->validate([ 
            'password' => 'required|string' 
        ]); 

        // Comparar contraseña con password_hash 

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

        // Entrar al panel 

        return redirect('/admin-panel'); 
    } 

    // NOTIFICACIONES 
    public function notifications() 
    { 
        $notifications = AdminNotification::latest() 
            ->get(); 

        return view( 
            'admin.notifications', 
            compact('notifications') 
        ); 
    } 

    // MARCAR NOTIFICACIÓN COMO LEÍDA 
    public function markNotificationAsRead($id) 
    { 
        $notification = AdminNotification::findOrFail($id); 

        $notification->read = 1; 

        $notification->save(); 

        return back(); 
    } 

    // MODERADORES 
    public function moderators() 
{ 
    $moderators = User::withTrashed() 
        ->where('role', 'MODERATOR') 
        ->latest() 
        ->get(); 

    return view( 
        'admin.moderators', 
        compact('moderators') 
    ); 
} 

    // REPORTES 
    public function reports() 
    { 
        $openCases = CaseFile::where( 
            'status', 
            'Abierto' 
        )->count(); 

        $followUpCases = CaseFile::where( 
        'status', 
        'En seguimiento' 
        )->count(); 

        $pendingCases = $followUpCases; 

        $closedCases = CaseFile::where( 
            'status', 
            'Cerrado' 
        )->count(); 

        // USUARIOS 

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
            'Activo' 
        ) 
        ->count(); 

        // CASOS POR MES 

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
                'followUpCases', 
                'pendingCases', 
                'usersCount', 
                'moderatorsCount', 
                'monthlyCases' 
            ) 
        ); 
    } 

    // EXPORTAR PDF 
    public function exportPdf(Request $request) 
    { 
        $casesQuery = CaseFile::with('moderator'); 

        // APLICAR FECHA INICIAL 

        if ($request->filled('from')) { 
            $casesQuery->where( 
                'created_at', 
                '>=', 
                Carbon::parse( 
                    $request->input('from') 
                )->startOfDay() 
            ); 
        } 

        // APLICAR FECHA FINAL 

        if ($request->filled('to')) { 
            $casesQuery->where( 
                'created_at', 
                '<=', 
                Carbon::parse( 
                    $request->input('to') 
                )->endOfDay() 
            ); 
        } 

        $cases = $casesQuery 
            ->orderBy( 
                'created_at', 
                'desc' 
            ) 
            ->get(); 

        $pdf = Pdf::loadView( 
            'admin.reports-pdf', 
            compact('cases') 
        ); 

        return $pdf->download( 
            'reporte-UMG.pdf' 
        ); 
    } 

    // EXPORTAR EXCEL
public function exportExcel(Request $request)
{
    $request->validate([
        'from' => 'nullable|date',
        'to'   => 'nullable|date|after_or_equal:from',
    ]);

    $cases = CaseFile::with('moderator')
        ->when($request->from, fn ($q, $f) => $q->whereDate('created_at', '>=', $f))
        ->when($request->to,   fn ($q, $t) => $q->whereDate('created_at', '<=', $t))
        ->latest()
        ->get();

    $spreadsheet = (new ReporteCasosExport($cases))->build();

    return response()->streamDownload(function () use ($spreadsheet) {
        (new Xlsx($spreadsheet))->save('php://output');
    }, 'reporte-casos-' . now()->format('Y-m-d_His') . '.xlsx', [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}

    // USUARIOS 
// USUARIOS  
public function users()  
{  
    // USUARIOS REGISTRADOS  
    $users = User::where(  
        'role',  
        'USER'  
    )  
    ->latest()  
    ->get();  

    // USUARIOS ELIMINADOS  
    $deletedUsers = User::onlyTrashed()  
        ->where(  
            'role',  
            'USER'  
        )  
        ->latest('deleted_at')  
        ->get();  

    return view(  
        'admin.users',  
        compact(  
            'users',  
            'deletedUsers'  
        )  
    );  
}

    // VER ÚLTIMO CAMBIO DE PERFIL 
public function viewProfileChange($id) 
{ 
    $user = User::findOrFail($id);  
    $profileChanges = AuditLog::where( 
        'action', 
        'update_profile' 
    ) 
    ->where( 
        'target_id', 
        $user->uuid 
    ) 
    ->latest('created_at') 
    ->get(); 

    return view( 
        'admin.profile-change', 
        compact( 
            'user', 
            'profileChanges' 
        ) 
    ); 
} 

    // ACTIVAR USUARIO 
    public function activateUser($id) 
    { 
        $user = User::findOrFail($id); 

        $user->status = 'Activo'; 

        $user->save(); 

        return back()->with( 
            'success', 
            'Usuario activado correctamente' 
        ); 
    } 

    // SUSPENDER USUARIO 
    public function suspendUser($id) 
    { 
        $user = User::findOrFail($id); 

        $user->status = 'Bloqueado'; 

        $user->save(); 

        return back()->with( 
            'success', 
            'Usuario bloqueado correctamente' 
        ); 
    } 

    // ELIMINAR USUARIO 
    public function deleteUser($id) 
    { 
        $user = User::findOrFail($id); 

        $user->delete(); 

        return back()->with( 
            'success', 
            'Usuario eliminado correctamente' 
        ); 
    } 

    // RESTAURAR USUARIO 
    public function restoreUser($id) 
    { 
        $user = User::withTrashed() 
            ->findOrFail($id); 

        $user->restore(); 

        $user->status = 'Activo'; 

        $user->save(); 

        return back()->with( 
            'success', 
            'Usuario restaurado correctamente' 
        ); 
    } 
    // RESTAURAR USUARIOS SELECCIONADOS  
public function restoreUsers(Request $request)  
{  
    $request->validate([  
        'users' => [  
            'required',  
            'array',  
            'min:1'  
        ],  
        'users.*' => [  
            'required',  
            'string'  
        ],  
    ]);  

    $userUuids = $request->input('users');  

    $users = User::onlyTrashed()  
        ->where(  
            'role',  
            'USER'  
        )  
        ->whereIn(  
            'uuid',  
            $userUuids  
        )  
        ->get();  

    foreach ($users as $user) {  
        $user->restore();  
        $user->status = 'Activo';  
        $user->save();  
    }  

    return back()->with(  
        'success',  
        $users->count() === 1  
            ? 'Usuario restaurado correctamente'  
            : 'Usuarios restaurados correctamente'  
    );  
}

    // CONFIGURACIÓN 
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

    // GUARDAR CONFIGURACIÓN 
    public function saveConfiguration( 
        Request $request 
    ) { 
        $request->validate([ 
            'system_name' => 
                'required|string|max:255', 
        ]); 

        $settings = SystemSetting::first(); 

        if (!$settings) { 
            $settings = new SystemSetting(); 

            $settings->id = 1; 
        } 

        $settings->system_name = 
            $request->system_name; 

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

    // GENERAR NICKNAME ANÓNIMO 
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

    // PANEL ADMINISTRATIVO 
    public function panel() 
    { 
        $notifications = 
            AdminNotification::orderBy( 
                'created_at', 
                'desc' 
            ) 
            ->limit(10) 
            ->get(); 

        $unreadNotifications = 
            AdminNotification::where( 
                'read', 
                0 
            )->count(); 

        $cases = CaseFile::with( 
            'moderator' 
        ) 
        ->orderBy( 
            'created_at', 
            'desc' 
        ) 
        ->get(); 

        return view( 
            'admin.panel', 
            compact( 
                'notifications', 
                'unreadNotifications', 
                'cases' 
            ) 
        ); 
    } 

    // EDITAR CASO 
    public function editCase($id) 
    { 
        $case = CaseFile::with([ 
            'user', 
            'moderator' 
        ])->findOrFail($id); 

        $this->authorize('update', $case); 

        return view( 
            'admin.edit-case', 
            compact('case') 
        ); 
    } 

    // ELIMINAR CASO 
    public function deleteCase($id) 
    { 
        $case = CaseFile::findOrFail($id); 

        $this->authorize('delete', $case); 

        $case->delete(); 

        return redirect( 
            '/admin/cases' 
        )->with( 
            'success', 
            'Caso eliminado correctamente' 
        ); 
    } 

    // FINALIZAR CASO 
public function finishCase($id) 
{ 
    $case = CaseFile::findOrFail($id); 

    $this->authorize('update', $case); 

    $oldStatus = $case->status; 

    $case->status = 'Cerrado'; 

    $case->save(); 

    if ($oldStatus !== $case->status) { 

        AuditLog::create([ 
            'action' => 'admin_finish_case', 
            'performed_by' => Auth::user()->uuid, 
            'target_type' => 'CaseFile', 
            'target_id' => (string) $case->id, 
            'changes' => [ 
                'case_number' => $case->case_number, 
                'type' => $case->type, 
                'status' => [ 
                    'before' => $oldStatus, 
                    'after' => $case->status, 
                ], 
            ], 
        ]); 
    } 

    AdminNotification::create([ 
        'message' => 
            'El caso ' 
            . $case->case_number 
            . ' fue finalizado por el administrador.' 
    ]); 

    return back()->with( 
        'success', 
        'Caso finalizado correctamente.' 
    ); 
} 

    // AGREGAR COMENTARIO A CASO 
    public function saveComment( 
        Request $request, 
        $id 
    ) { 
        $request->validate([ 
            'comment' => [ 
            'required', 
            'string', 
            'max:5000' 
                ], 

            'color' => [ 
            'nullable', 
            'string', 
            'max:50' 
                ] 
]); 


        $case = CaseFile::findOrFail($id); 

        $this->authorize('update', $case); 

        $user = Auth::user(); 

        if (!$user) { 
            return back()->with( 
                'error', 
                'Debe iniciar sesión para agregar una observación.' 
            ); 
        } 

        // Solo el ADMINISTRADOR puede crear observaciones 

        if ($user->role !== 'ADMIN') { 
            return back()->with( 
                'error', 
                'Solo el administrador puede agregar observaciones.' 
            ); 
        } 

        // Guardar observación 

        CaseComment::create([ 
            'case_id' => $case->id, 
            'user_id' => $user->uuid, 
            'type' => 'OBSERVACION', 
            'comment' => trim($request->comment), 
            'color' => $request->color 
        ]); 

        // Notificar al moderador 

        return back()->with( 
            'success', 
            'Observación agregada correctamente.' 
        ); 
    } 
}