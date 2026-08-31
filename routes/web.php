<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ChatController;

/*HOME*/

Route::get('/', function () {
    return view('welcome');
});

/*LOGIN*/

Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)->name('login');

Route::post(
    '/login',
    [AuthController::class, 'login']
);

Route::post(
    '/register',
    [AuthController::class, 'register']
);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*RECUPERACIÓN DE CONTRASEÑA*/

Route::get(
    '/forgot-password',
    function () {
        return view('auth.forgot');
    }
);

Route::post(
    '/forgot-password',
    [UserController::class, 'sendResetCode']
);

Route::get(
    '/reset-password',
    function () {
        return view('auth.reset');
    }
);

Route::post(
    '/reset-password',
    [UserController::class, 'resetPassword']
);

/*
|--------------------------------------------------------------------------
| CAMBIO DE CONTRASEÑA
|--------------------------------------------------------------------------
|
| Estas rutas solamente requieren autenticación.
| Se mantienen fuera de must.change.password para que
| el usuario pueda entrar a cambiar su contraseña.
|
*/

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/change-password',
        [UserController::class, 'showChangePassword']
    )->name('password.change');

    Route::post(
        '/change-password',
        [UserController::class, 'changePassword']
    )->name('password.update');

});


/*
|--------------------------------------------------------------------------
| USUARIO AUTENTICADO
|--------------------------------------------------------------------------
|
| Requiere:
| 1. Usuario autenticado
| 2. Cambio de contraseña si corresponde
| 3. Modo mantenimiento para usuarios no administradores
|
*/

Route::middleware([
    'auth',
    'must.change.password',
    'maintenance'
])->group(function () {

    /*CHATBOT*/

Route::get(
    '/chat',
    [ChatController::class, 'index']
)->name('chat.index');

Route::get(
    '/chat/messages',
    [ChatController::class, 'messages']
)->name('chat.messages');

Route::post(
    '/chat/message',
    [ChatController::class, 'sendMessage']
)->name('chat.message');

    /*MODERADOR*/

    Route::middleware(['role:MODERATOR'])->group(function () {

    Route::get(
        '/moderator/dashboard',
        [ModeratorController::class, 'dashboard']
    )->name('moderator.dashboard');

    Route::get(
        '/moderator/cases',
        [ModeratorController::class, 'cases']
    )->name('moderator.cases');

    Route::get(
        '/moderator/case/{id}',
        [ModeratorController::class, 'viewCase']
    )->name('moderator.case');

    Route::post(
        '/moderator/case/{id}/comment',
        [ModeratorController::class, 'saveComment']
    )->name('moderator.case.comment');

    Route::put(
        '/moderator/case/{id}/status',
        [ModeratorController::class, 'updateStatus']
    )->name('moderator.case.status');

    Route::get(
    '/moderator/dashboard',
    [ModeratorController::class, 'dashboard']
    )->name('moderator.dashboard');

    Route::get(
    '/moderator/chats',
    [ModeratorController::class, 'chats']
    )->name('moderator.chats');

    Route::get(
    '/moderator/chat/{id}',
    [ModeratorController::class, 'viewChat']
    )->name('moderator.chat');

    Route::post(
    '/moderator/chat/{id}/message',
    [ModeratorController::class, 'sendChatMessage']
    )->name('moderator.chat.message');
});

    /*RELACIÓN DE CASOS*/

    Route::post(
        '/cases/suicide',
        [CaseController::class, 'createSuicideCase']
    )->name('cases.suicide');

    Route::post(
        '/cases/abuse',
        [CaseController::class, 'createAbuseCase']
    )->name('cases.abuse');


    /*DASHBOARD*/

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    /*FORO*/

    Route::get(
        '/forum',
        [ForumController::class, 'index']
    )->name('forum.index');

    Route::post(
        '/forum/create',
        [ForumController::class, 'create']
    )->name('forum.create');

    Route::patch(
        '/forum/{uuid}/restrict',
        [ForumController::class, 'restrict']
    )->name('forum.restrict');

    Route::patch(
        '/forum/{uuid}/restore',
        [ForumController::class, 'restore']
    )->name('forum.restore');

    /*PERFIL*/

    Route::get(
        '/profile',
        [UserController::class, 'profile']
    );

    /*EVALUACIÓN*/

    Route::get(
        '/evaluation',
        fn () => view('evaluation')
    );

    /*BOTÓN DE PÁNICO*/

    Route::get(
        '/panic-button',
        fn () => view('panic')
    );

    /*CASOS*/

    Route::get(
        '/casesAbusoSexual',
        fn () => view('casesAbusoSexual')
    );

    Route::get(
        '/casesSuicidio',
        fn () => view('casesSuicidio')
    );

    Route::get(
        '/cases',
        fn () => view('cases')
    );

});

/*ACCESO ADMINISTRATIVO
Solo ADMIN.
Aquí se solicita la contraseña administrativa.*/

Route::middleware([
    'auth',
    'role:ADMIN'
])->group(function () {

    /*PANTALLA DE ACCESO ADMINISTRATIVO*/

    Route::get(
        '/admin-access',
        function () {
            return view('admin.access');
        }
    );

    /*VERIFICAR CONTRASEÑA ADMINISTRATIVA*/

    Route::post(
        '/admin-access',
        [AdminController::class, 'verifyAdmin']
    );

    /*
    |--------------------------------------------------------------------------
    | ÁREA ADMINISTRATIVA VERIFICADA
    |--------------------------------------------------------------------------
    | Requiere:
    | 1. Usuario autenticado
    | 2. Rol ADMIN
    | 3. admin_verified = true
    */

    Route::middleware([
        'admin.verified'
    ])->group(function () {

    /*PANEL PRINCIPAL*/

        Route::get(
            '/admin-panel',
            [AdminController::class, 'panel']
        );

    /*NOTIFICACIONES*/

Route::get(
    '/admin/notifications',
    [AdminController::class, 'notifications']
)->name('admin.notifications');

Route::post(
    '/admin/notifications/{id}/read',
    [AdminController::class, 'markNotificationAsRead']
)->name('admin.notifications.read');

    /*DASHBOARD ADMIN*/

        Route::get(
            '/admin',
            [AdminController::class, 'dashboard']
        );


    /*USUARIOS*/

        Route::get(
            '/admin/users',
            [AdminController::class, 'users']
        );

        Route::get(
            '/admin/user/{id}/activate',
            [AdminController::class, 'activateUser']
        );

        Route::get(
            '/admin/user/{id}/suspend',
            [AdminController::class, 'suspendUser']
        );

        Route::get(
            '/admin/user/{id}/delete',
            [AdminController::class, 'deleteUser']
        );

        Route::get(
            '/admin/user/{id}/restore',
            [AdminController::class, 'restoreUser']
        );


    /*EDITAR USUARIOS*/

        Route::get(
            '/admin/edit/{id}',
            [UserController::class, 'edit']
        );

        Route::post(
            '/admin/update/{id}',
            [UserController::class, 'update']
        );


    /*MODERADORES*/

        Route::get(
            '/admin/moderators',
            [AdminController::class, 'moderators']
        );

        Route::post(
            '/moderator/create',
            [AdminController::class, 'createModerator']
        );

        Route::delete(
            '/moderator/{id}',
            [AdminController::class, 'deleteModerator']
        );

        Route::post(
            '/moderator/restore/{id}',
            [AdminController::class, 'restoreModerator']
        );


    /*CASOS*/

        Route::get(
            '/admin/cases',
            [AdminController::class, 'cases']
        );

        Route::get(
            '/admin/case/{id}',
            [AdminController::class, 'viewCase']
        );

        Route::put(
            '/case/{id}',
            [AdminController::class, 'updateCase']
        );

        Route::get(
            '/admin/case/edit/{id}',
            [AdminController::class, 'editCase']
        );

        Route::get(
            '/admin/case/delete/{id}',
            [AdminController::class, 'deleteCase']
        );

        Route::get(
            '/admin/case/{id}/approve',
            [AdminController::class, 'approveCase']
        );

        Route::post(
            '/admin/case/comment/{id}',
            [AdminController::class, 'saveComment']
        );


    /*REPORTES*/

        Route::get(
            '/admin/reports',
            [AdminController::class, 'reports']
        );

        Route::get(
            '/admin/reports/excel',
            [AdminController::class, 'exportExcel']
        );

        Route::get(
            '/admin/reports/pdf',
            [AdminController::class, 'exportPdf']
        );

    /*CONFIGURACIÓN*/

        Route::get(
            '/admin/configuration',
            [AdminController::class, 'configuration']
        );

        Route::post(
            '/admin/configuration/save',
            [AdminController::class, 'saveConfiguration']
        );

    /*ELIMINAR USUARIO*/

        Route::get(
            '/admin/delete/{id}',
            [UserController::class, 'destroy']
        );
    });
});

    /*CONTACTO*/

Route::post(
    '/contact',
    [ContactController::class, 'store']
)->name('contact.store');