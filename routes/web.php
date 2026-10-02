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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\TwoFactorController;

    /* HOME */

Route::get('/', function () {
    return view('welcome');
});


    /* LOGIN */

Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)->name('login');

Route::post(
    '/login',
    [AuthController::class, 'login']
);

Route::get('/register', function () {
    return view('auth.login');
})->name('register');

Route::post(
    '/register',
    [AuthController::class, 'register']
);

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)->middleware('auth')->name('logout');

Route::post(
    '/auth/google',
    [AuthController::class, 'googleLogin']
)->name('google.login');

    /* Autenticación de dos factores */

Route::middleware('guest')->group(function () {

    Route::get('/two-factor/setup', [
        TwoFactorController::class,
        'showSetup'
    ])->name('two-factor.setup');

    Route::post('/two-factor/enable', [
        TwoFactorController::class,
        'enable'
    ])->name('two-factor.enable');

    Route::get('/two-factor/verify', [
        TwoFactorController::class,
        'showVerify'
    ])->name('two-factor.verify');

    Route::post('/two-factor/verify', [
        TwoFactorController::class,
        'verify'
    ])->name('two-factor.verify.submit');

    Route::get('/two-factor/cancel', [
        TwoFactorController::class,
        'cancel'
    ])->name('two-factor.cancel');
});

    /* RECUPERACIÓN DE CONTRASEÑA */

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

    /* CAMBIO DE CONTRASEÑA */

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

    /* USUARIO AUTENTICADO */

Route::middleware([
    'auth',
    'must.change.password',
    'maintenance'
])->group(function () {

    /* PERFIL */

    Route::get(
        '/perfil',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::put(
        '/perfil',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::put(
        '/perfil/password',
        [ProfileController::class, 'updatePassword']
    )->name('profile.password.update');


    /* SEGUIMIENTO DE CASOS */

    Route::get(
        '/cases',
        [CaseController::class, 'tracking']
    )->name('cases.tracking');

    /* MARCAR NOTIFICACIÓN COMO LEÍDA */

    Route::post(
        '/cases/notifications/{id}/read',
        [CaseController::class, 'markNotificationAsRead']
    )->name('cases.notification.read');

    /* CHAT DEL USUARIO */

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

    /* RELACIÓN DE CASOS */

    Route::post(
        '/cases/suicide',
        [CaseController::class, 'createSuicideCase']
    )->name('cases.suicide');

    Route::post(
        '/cases/abuse',
        [CaseController::class, 'createAbuseCase']
    )->name('cases.abuse');

    /* DASHBOARD */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    /* FORO */

    Route::get(
        '/forum',
        [ForumController::class, 'index']
    )->name('forum.index');

    Route::post(
        '/forum/create',
        [ForumController::class, 'create']
    )->name('forum.create');

    Route::middleware(['role:ADMIN,MODERATOR'])->group(function () {

        Route::patch(
            '/forum/{uuid}/restrict',
            [ForumController::class, 'restrict']
        )->name('forum.restrict');

        Route::patch(
            '/forum/{uuid}/restore',
            [ForumController::class, 'restore']
        )->name('forum.restore');

    });

    /* PERFIL */

    Route::get(
        '/profile',
        [UserController::class, 'profile']
    );

    /* EVALUACIONES DEL USUARIO */

    Route::middleware(['role:USER'])->group(function () {

        Route::get(
            '/evaluation',
            [EvaluacionController::class, 'index']
        )->name('evaluation.index');

        Route::get(
            '/evaluation/{uuid}',
            [EvaluacionController::class, 'show']
        )->name('evaluation.show');

        Route::post(
            '/evaluation/{uuid}',
            [EvaluacionController::class, 'submit']
        )->name('evaluation.submit');

    });

    /* BOTÓN DE PÁNICO */

    Route::get(
        '/panic-button',
        fn () => view('panic')
    );

    /* CASOS INFORMATIVOS */

    Route::get(
        '/casesAbusoSexual',
        fn () => view('casesAbusoSexual')
    );

    Route::get(
        '/casesSuicidio',
        fn () => view('casesSuicidio')
    );

});

    /* MODERADOR */

Route::middleware([
    'auth',
    'must.change.password',
    'role:MODERATOR'
])->group(function () {

    /* DASHBOARD DEL MODERADOR */

    Route::get(
        '/moderator/dashboard',
        [ModeratorController::class, 'dashboard']
    )->name('moderator.dashboard');

    Route::get(
        '/moderator/evaluations',
        [EvaluacionController::class, 'moderatorIndex']
    )->name('moderator.evaluations');

    Route::get(
        '/moderator/evaluations/create',
        [EvaluacionController::class, 'create']
    )->name('moderator.evaluations.create');

    Route::post(
        '/moderator/evaluations',
        [EvaluacionController::class, 'store']
    )->name('moderator.evaluations.store');

    Route::get(
        '/moderator/evaluations/{uuid}/edit',
        [EvaluacionController::class, 'edit']
    )->name('moderator.evaluations.edit');

    Route::put(
        '/moderator/evaluations/{uuid}',
        [EvaluacionController::class, 'update']
    )->name('moderator.evaluations.update');

    Route::delete(
        '/moderator/evaluations/{uuid}',
        [EvaluacionController::class, 'destroy']
    )->name('moderator.evaluations.destroy');

    Route::get('/moderator/evaluation-results/user/{userUuid}', 
    [EvaluacionController::class, 'moderatorUserResults'])
    ->name('moderator.evaluation-results.user');

    Route::get('/moderator/evaluation-result/{id}', 
    [ModeratorController::class, 'evaluationResult'])
    ->name('moderator.evaluation.result');

    Route::get('/moderator/evaluation-result/{id}/pdf', 
    [ModeratorController::class, 'downloadEvaluationResult'])
    ->name('moderator.evaluation.pdf');

    /* RESULTADOS DE EVALUACIONES */

    Route::get(
        '/moderator/evaluation-results/{id}',
        [ModeratorController::class, 'evaluationResult']
    )->name('moderator.evaluation-result');

    Route::get(
        '/moderator/evaluation-results/{id}/pdf',
        [ModeratorController::class, 'downloadEvaluationResult']
    )->name('moderator.evaluation-result.pdf');

    Route::post(
        '/moderator/notifications/evaluations/{id}/read',
        [ModeratorController::class, 'markEvaluationNotificationAsRead']
    )->name('moderator.evaluation-notifications.read');

    /* CASOS DEL MODERADOR */

    Route::get(
        '/moderator/cases',
        [ModeratorController::class, 'cases']
    )->name('moderator.cases');

    Route::get(
        '/moderator/cases/{id}',
        [ModeratorController::class, 'viewCase']
    )->name('moderator.case');

    Route::post(
        '/moderator/cases/{id}/comment',
        [ModeratorController::class, 'saveComment']
    )->name('moderator.case.comment');

    Route::put(
        '/moderator/cases/{id}/update',
        [ModeratorController::class, 'updateCase']
    )->name('moderator.case.update');

    /* CHATS DEL MODERADOR */

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

    Route::post(
        '/moderator/chat/{id}/close',
        [ModeratorController::class, 'closeChat']
    )->name('moderator.chat.close');

});

    /* ACCESO ADMINISTRATIVO */

Route::middleware([
    'auth',
    'role:ADMIN'
])->group(function () {

    /* PANTALLA DE ACCESO ADMINISTRATIVO */

    Route::get(
        '/admin-access',
        function () {
            return view('admin.access');
        }
    );

    /* VERIFICAR CONTRASEÑA ADMINISTRATIVA */

    Route::post(
        '/admin-access',
        [AdminController::class, 'verifyAdmin']
    );

    /* ÁREA ADMINISTRATIVA VERIFICADA */

    Route::middleware([
        'admin.verified'
    ])->group(function () {

    /* PANEL PRINCIPAL */

        Route::get(
            '/admin-panel',
            [AdminController::class, 'panel']
        );

    /* NOTIFICACIONES */

        Route::get(
            '/admin/notifications',
            [AdminController::class, 'notifications']
        )->name('admin.notifications');

        Route::post(
            '/admin/notifications/{id}/read',
            [AdminController::class, 'markNotificationAsRead']
        )->name('admin.notifications.read');

        /* DASHBOARD ADMIN */

        Route::get(
            '/admin',
            [AdminController::class, 'dashboard']
        );

        /* USUARIOS */

        Route::get(
            '/admin/users',
            [AdminController::class, 'users']
        );

        Route::patch( 
            '/admin/user/{id}/activate', 
            [AdminController::class, 'activateUser'] 
        ); 

        Route::patch( 
            '/admin/user/{id}/suspend', 
            [AdminController::class, 'suspendUser'] 
        ); 

        Route::delete( 
            '/admin/user/{id}/delete', 
            [AdminController::class, 'deleteUser'] 
        ); 

        Route::patch( 
            '/admin/user/{id}/restore', 
            [AdminController::class, 'restoreUser'] 
        );

        Route::get(
            '/admin/user/{id}/profile-changes',
            [AdminController::class, 'viewProfileChange']
        )->name('admin.user.profile-changes');

        Route::patch(
            '/admin/users/restore',
            [AdminController::class, 'restoreUsers']
        );

        /* MODERADORES */

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

        /* CASOS ADMINISTRATIVOS */

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

        Route::delete(
            '/admin/case/delete/{id}',
            [AdminController::class, 'deleteCase']
        );

        Route::post(
            '/admin/case/comment/{id}',
            [AdminController::class, 'saveComment']
        );

        Route::post(
            '/admin/case/{id}/finish',
            [AdminController::class, 'finishCase']
        );

        /* REPORTES */

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


        /* CONFIGURACIÓN */

        Route::get(
            '/admin/configuration',
            [AdminController::class, 'configuration']
        );

        Route::post(
            '/admin/configuration/save',
            [AdminController::class, 'saveConfiguration']
        );

        /* ELIMINAR USUARIO */

        Route::delete(
            '/admin/delete/{id}',
            [UserController::class, 'destroy']
        );

    });

});

    /* CONTACTO */

Route::post(
    '/contact',
    [ContactController::class, 'store']
)->name('contact.store'); 
