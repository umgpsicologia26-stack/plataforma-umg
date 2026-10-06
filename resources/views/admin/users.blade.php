<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">
<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

<title>Usuarios | UMG</title>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        background:
            linear-gradient(
                135deg,
                #eef4ff,
                #f8fbff
            );
        min-height: 100vh;
        color: #1f2937;
    }

    /*CONTENEDOR*/
    .container {
        width: 100%;
        max-width: 1250px;
        margin: 0 auto;
        padding: 35px 20px 50px;
    }

    /*BOTÓN VOLVER*/
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        text-decoration: none;
        color: #374151;
        background: #ffffff;
        padding: 11px 18px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 20px;
        box-shadow:
            0 3px 10px rgba(0,0,0,0.05);
        transition: all .2s ease;
    }

    .back-button:hover {
        background: #f3f4f6;
        transform: translateX(-2px);
    }

    /*ENCABEZADO*/
    .page-header {
        background: #ffffff;
        border-radius: 18px;
        padding: 25px 30px;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.07);
        border: 1px solid #e8edf5;
    }

    .title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 25px;
        font-weight: 700;
        color: #1f2937;
    }

    .title i {
        color: #2563eb;
    }

    .subtitle {
        margin-top: 7px;
        color: #6b7280;
        font-size: 14px;
    }

    /*TARJETA*/
    .card {
        background: #ffffff;
        border-radius: 18px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.07);
        border: 1px solid #e8edf5;
    }

    /*ENCABEZADO TABLA*/
    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 20px;
    }

    .table-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }

    .table-title i {
        color: #2563eb;
    }

    .count {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    /*TABLA*/
    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 1050px;
    }

    th {
        background: #f8fafc;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 14px 16px;
        text-align: left;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }

    th:first-child {
        border-left: 1px solid #e5e7eb;
        border-radius: 10px 0 0 10px;
    }

    th:last-child {
        border-right: 1px solid #e5e7eb;
        border-radius: 0 10px 10px 0;
    }

    td {
        padding: 15px 16px;
        border-bottom: 1px solid #edf0f4;
        color: #374151;
        font-size: 14px;
        background: #ffffff;
        vertical-align: middle;
    }

    tbody tr {
        transition: background .2s ease;
    }

    tbody tr:hover td {
        background: #f8fafc;
    }

    /*CÓDIGO ÚNICO*/
    .anonymous-code {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .4px;
    }

    /*ESTADOS*/
    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    .status.active {
        background: #ecfdf5;
        color: #15803d;
    }

    .status.active .status-dot {
        background: #22c55e;
    }

    .status.blocked {
        background: #fff7ed;
        color: #c2410c;
    }

    .status.blocked .status-dot {
        background: #f97316;
    }

    .status.pending {
        background: #fffbeb;
        color: #a16207;
    }

    .status.pending .status-dot {
        background: #eab308;
    }

    .status.unknown {
        background: #f3f4f6;
        color: #4b5563;
    }

    .status.unknown .status-dot {
        background: #9ca3af;
    }

    /*ACCIONES*/
    .actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 11px;
        border-radius: 8px;
        text-decoration: none;
        border: 1px solid transparent;
        font-size: 12px;
        font-weight: 600;
        transition: all .2s ease;
        white-space: nowrap;
        cursor: pointer;
    }

    .action-button:hover {
        transform: translateY(-1px);
    }

    /*ACTIVAR*/
    .activate {
        background: #ecfdf5;
        color: #15803d;
        border-color: #bbf7d0;
    }

    .activate:hover {
        background: #dcfce7;
    }

    /*SUSPENDER*/
    .suspend {
        background: #fff7ed;
        color: #c2410c;
        border-color: #fed7aa;
    }

    .suspend:hover {
        background: #ffedd5;
    }

    /*ELIMINAR*/
    .delete {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    .delete:hover {
        background: #fee2e2;
    }

    /*RESTAURAR*/
    .restore {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }

    .restore:hover {
        background: #dbeafe;
    }

    /*VISUALIZAR*/
    .view-deleted {
        background: #f8fafc;
        color: #374151;
        border-color: #d1d5db;
    }

    .view-deleted:hover {
        background: #f1f5f9;
    }

    /* BUSCADOR */
    .search-container {
        display: none;
        margin-bottom: 20px;
    }

    .search-box {
        width: 100%;
        padding: 11px 14px 11px 40px;
        border: 1px solid #dbe3ee;
        border-radius: 10px;
        font-size: 14px;
        outline: none;
        transition: all .2s ease;
        background: #ffffff;
    }

    .search-box:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    }

    .search-wrapper {
        position: relative;
        width: 100%;
    }

    .search-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    /* SELECCIÓN */
    .select-cell {
        width: 45px;
        text-align: center;
    }

    .user-checkbox {
        width: 17px;
        height: 17px;
        cursor: pointer;
        accent-color: #2563eb;
    }

    /* BOTÓN RESTAURAR SELECCIONADOS */
    .restore-actions {
        display: none;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 20px;
        padding: 15px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .selected-count {
        color: #6b7280;
        font-size: 13px;
        font-weight: 600;
    }

    /* MENSAJE VACÍO */
    .empty {
        text-align: center;
        padding: 35px 20px !important;
        color: #6b7280;
    }

    /* SECCIÓN USUARIOS BLOQUEADOS POR INTENTOS FALLIDOS */
    .blocked-failed {
        background: #fff7ed;
        color: #c2410c;
        border-color: #fed7aa;
    }

    .blocked-failed:hover {
        background: #ffedd5;
    }

    .blocked-reason {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    /*RESPONSIVE*/
    @media (max-width: 700px) {
        .container {
            padding:
                20px 14px 40px;
        }

        .page-header,
        .card {
            padding: 22px 18px;
        }

        .title {
            font-size: 21px;
        }

        .table-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .restore-actions {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

</head>

<body>

<div class="container">

<!--VOLVER AL PANEL-->
<a
    href="/admin-panel"
    class="back-button">

    <i class="fas fa-arrow-left"></i>
    Volver al panel

</a>

<!--ENCABEZADO-->
<div class="page-header">

    <div class="title">

        <i class="fas fa-users"></i>

        Gestión de Usuarios

    </div>

    <div class="subtitle">

        Administra los usuarios registrados
        en la plataforma UMG.

    </div>

</div>

<!--LISTADO DE USUARIOS-->
<div class="card">

    <div class="table-header">

        <div class="table-title">

            <i class="fas fa-user-group"></i>

            Usuarios registrados

        </div>

        <span class="count">

            {{ $users->count() }}

            {{ $users->count() == 1
                ? 'usuario'
                : 'usuarios'
            }}

        </span>

    </div>

    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>
                        Código único
                    </th>

                    <th>
                        Nombre
                    </th>

                    <th>
                        Apellido
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Celular
                    </th>

                    <th>
                        Estado
                    </th>

                    <th>
                        Fecha registro
                    </th>

                    <th>
                        Acciones
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr>

                        <!-- CÓDIGO -->
                        <td>

                            <span class="anonymous-code">

                                <i class="fas fa-fingerprint"></i>

                                {{ $user->anonymous_nickname }}

                            </span>

                        </td>

                        <!-- NOMBRE -->
                        <td>
                            {{ $user->first_name }}
                        </td>

                        <!-- APELLIDO -->
                        <td>
                            {{ $user->last_name }}
                        </td>

                        <!-- EMAIL -->
                        <td>
                            {{ $user->email }}
                        </td>

                        <!-- TELÉFONO -->
                        <td>
                            {{ $user->phone ?? 'No registrado' }}
                        </td>

                        <!-- ESTADO -->
                        <td>

                            @if($user->status === 'Activo')

                                <span class="status active">

                                    <span class="status-dot"></span>

                                    Activo

                                </span>

                            @elseif($user->status === 'Bloqueado')

                                <span class="status blocked">

                                    <span class="status-dot"></span>

                                    Bloqueado

                                </span>

                            @elseif($user->status === 'Pendiente')

                                <span class="status pending">

                                    <span class="status-dot"></span>

                                    Pendiente

                                </span>

                            @else

                                <span class="status unknown">

                                    <span class="status-dot"></span>

                                    {{ $user->status }}

                                </span>

                            @endif

                        </td>

                        <!-- FECHA -->
                        <td>

                            {{ $user->created_at
                                ? $user->created_at->format('d/m/Y')
                                : '—'
                            }}

                        </td>

                        <!-- ACCIONES -->
                        <td>

                            <div class="actions">

                                <form
                                    action="/admin/user/{{ $user->uuid }}/activate"
                                    method="POST"
                                    style="display:inline;">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="action-button activate"
                                        title="Activar usuario">

                                        <i class="fas fa-check"></i>

                                        Activar

                                    </button>

                                </form>

                                <form
                                    action="/admin/user/{{ $user->uuid }}/suspend"
                                    method="POST"
                                    style="display:inline;">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="action-button suspend"
                                        title="Suspender usuario">

                                        <i class="fas fa-ban"></i>

                                        Suspender

                                    </button>

                                </form>

                                <form
                                    action="/admin/user/{{ $user->uuid }}/delete"
                                    method="POST"
                                    style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-button delete"
                                        title="Eliminar usuario">

                                        <i class="fas fa-trash"></i>

                                        Eliminar

                                    </button>

                                </form>

                                <a
                                    href="{{ route('admin.user.profile-changes', $user->uuid) }}"
                                    class="action-button view"
                                    title="Ver último cambio de perfil">

                                    <i class="fas fa-eye"></i>

                                    Ver cambios

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="empty">

                            <i class="fas fa-user-slash"></i>

                            <p>
                                No hay usuarios registrados.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<!-- ====================================================== -->
<!-- USUARIOS BLOQUEADOS POR INTENTOS FALLIDOS -->
<!-- ====================================================== -->

<div class="card">

    <div class="table-header">

        <div class="table-title">

            <i class="fas fa-user-lock"></i>

            Usuarios bloqueados por intentos fallidos

        </div>

        <span class="count">

            {{ $users->where('status', 'Bloqueado')->where('lock_reason', 'BRUTE_FORCE')->count() }}

            {{ $users->where('status', 'Bloqueado')->where('lock_reason', 'BRUTE_FORCE')->count() == 1
                ? 'usuario'
                : 'usuarios'
            }}

        </span>

    </div>

    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>
                        Código único
                    </th>

                    <th>
                        Nombre
                    </th>

                    <th>
                        Apellido
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Intentos fallidos
                    </th>

                    <th>
                        Motivo
                    </th>

                    <th>
                        Estado
                    </th>

                    <th>
                        Acción
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse(
                    $users->where('status', 'Bloqueado')
                         ->where('lock_reason', 'BRUTE_FORCE')
                    as $user
                )

                    <tr>

                        <!-- CÓDIGO -->
                        <td>

                            <span class="anonymous-code">

                                <i class="fas fa-fingerprint"></i>

                                {{ $user->anonymous_nickname }}

                            </span>

                        </td>

                        <!-- NOMBRE -->
                        <td>
                            {{ $user->first_name }}
                        </td>

                        <!-- APELLIDO -->
                        <td>
                            {{ $user->last_name }}
                        </td>

                        <!-- EMAIL -->
                        <td>
                            {{ $user->email }}
                        </td>

                        <!-- INTENTOS -->
                        <td>

                            {{ $user->failed_login_attempts ?? 0 }}

                        </td>

                        <!-- MOTIVO -->
                        <td>

                            <span class="blocked-reason">

                                <i class="fas fa-shield-halved"></i>

                                Intentos fallidos

                            </span>

                        </td>

                        <!-- ESTADO -->
                        <td>

                            <span class="status blocked">

                                <span class="status-dot"></span>

                                Bloqueado

                            </span>

                        </td>

                        <!-- RESTAURAR -->
                        <td>

                            <form
                                method="POST"
                                action="{{ route('admin.users.restore-blocked', $user->uuid) }}">

                                @csrf

                                <button
                                    type="submit"
                                    class="action-button blocked-failed"
                                    title="Restaurar usuario bloqueado">

                                    <i class="fas fa-unlock"></i>

                                    Desbloquear usuario

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="empty">

                            <i class="fas fa-shield-check"></i>

                            <p>
                                No hay usuarios bloqueados por intentos fallidos.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<!-- USUARIOS ELIMINADOS -->
<div class="card">

    <div class="table-header">

        <div class="table-title">

            <i class="fas fa-user-slash"></i>

            Usuarios eliminados

        </div>

        <div class="actions">

            <span class="count">

                {{ $deletedUsers->count() }}

                {{ $deletedUsers->count() == 1
                    ? 'usuario'
                    : 'usuarios'
                }}

            </span>

            <button
                type="button"
                id="toggleDeletedUsers"
                class="action-button view-deleted">

                <i class="fas fa-eye"></i>

                Visualizar

            </button>

        </div>

    </div>


    <!-- CONTENIDO OCULTO -->
    <div id="deletedUsersContent" style="display:none;">

        <!-- BUSCADOR -->
        <div
            class="search-container"
            id="deletedSearch">

            <div class="search-wrapper">

                <i class="fas fa-search"></i>

                <input
                    type="text"
                    id="userSearch"
                    class="search-box"
                    placeholder="Buscar usuario por nombre o apellido...">

            </div>

        </div>


        <!-- FORMULARIO DE RESTAURACIÓN -->
        <form
            action="/admin/users/restore"
            method="POST"
            id="restoreUsersForm">

            @csrf
            @method('PATCH')

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th class="select-cell">

                                <i class="fas fa-check"></i>

                            </th>

                            <th>
                                Código único
                            </th>

                            <th>
                                Nombre
                            </th>

                            <th>
                                Apellido
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Celular
                            </th>

                            <th>
                                Fecha eliminación
                            </th>

                        </tr>

                    </thead>

                    <tbody id="deletedUsersTable">

                        @forelse($deletedUsers as $user)

                            <tr
                                data-name="{{ strtolower($user->first_name . ' ' . $user->last_name) }}">

                                <td class="select-cell">

                                    <input
                                        type="checkbox"
                                        class="user-checkbox"
                                        name="users[]"
                                        value="{{ $user->uuid }}">

                                </td>

                                <td>

                                    <span class="anonymous-code">

                                        <i class="fas fa-fingerprint"></i>

                                        {{ $user->anonymous_nickname }}

                                    </span>

                                </td>

                                <td>
                                    {{ $user->first_name }}
                                </td>

                                <td>
                                    {{ $user->last_name }}
                                </td>

                                <td>
                                    {{ $user->email }}
                                </td>

                                <td>
                                    {{ $user->phone ?? 'No registrado' }}
                                </td>

                                <td>

                                    {{ $user->deleted_at
                                        ? $user->deleted_at->format('d/m/Y H:i')
                                        : '—'
                                    }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="empty">

                                    <i class="fas fa-user-check"></i>

                                    <p>
                                        No hay usuarios eliminados.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- ACCIÓN DE RESTAURACIÓN -->
            <div
                class="restore-actions"
                id="restoreActions">

                <span
                    class="selected-count"
                    id="selectedCount">

                    0 usuarios seleccionados

                </span>

                <button
                    type="submit"
                    class="action-button restore"
                    id="restoreButton">

                    <i class="fas fa-rotate-left"></i>

                    Restaurar usuarios

                </button>

            </div>

        </form>

    </div>

</div>

</div>

<script>

    const toggleDeletedUsers =
        document.getElementById('toggleDeletedUsers');

    const deletedUsersContent =
        document.getElementById('deletedUsersContent');

    const deletedSearch =
        document.getElementById('deletedSearch');

    const userSearch =
        document.getElementById('userSearch');

    const restoreActions =
        document.getElementById('restoreActions');

    const selectedCount =
        document.getElementById('selectedCount');

    const restoreButton =
        document.getElementById('restoreButton');

    const checkboxes =
        document.querySelectorAll('.user-checkbox');


    /*
     * MOSTRAR / OCULTAR USUARIOS ELIMINADOS
     */
    toggleDeletedUsers.addEventListener('click', function () {

        const isHidden =
            deletedUsersContent.style.display === 'none';

        if (isHidden) {

            deletedUsersContent.style.display = 'block';

            deletedSearch.style.display = 'block';

            toggleDeletedUsers.innerHTML =
                '<i class="fas fa-eye-slash"></i> Ocultar';

            userSearch.focus();

        } else {

            deletedUsersContent.style.display = 'none';

            deletedSearch.style.display = 'none';

            toggleDeletedUsers.innerHTML =
                '<i class="fas fa-eye"></i> Visualizar';

        }

    });


    /*
     * ACTUALIZAR SELECCIÓN
     */
    function updateSelection() {

        const selected =
            document.querySelectorAll(
                '.user-checkbox:checked'
            );

        const total =
            selected.length;

        if (total === 0) {

            restoreActions.style.display =
                'none';

            return;

        }

        restoreActions.style.display =
            'flex';

        selectedCount.textContent =
            total === 1
                ? '1 usuario seleccionado'
                : total + ' usuarios seleccionados';

        restoreButton.innerHTML =
            total === 1
                ? '<i class="fas fa-rotate-left"></i> Restaurar usuario'
                : '<i class="fas fa-rotate-left"></i> Restaurar usuarios';

    }


    /*
     * ESCUCHAR CASILLAS
     */
    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            updateSelection
        );

    });


    /*
     * BUSCAR POR NOMBRE O APELLIDO
     */
    userSearch.addEventListener('input', function () {

        const search =
            this.value
                .toLowerCase()
                .trim();

        const rows =
            document.querySelectorAll(
                '#deletedUsersTable tr[data-name]'
            );

        rows.forEach(function (row) {

            const name =
                row.dataset.name;

            if (name.includes(search)) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    });


    /*
     * CONFIRMAR RESTAURACIÓN
     */
    document
        .getElementById('restoreUsersForm')
        .addEventListener('submit', function (event) {

            const selected =
                document.querySelectorAll(
                    '.user-checkbox:checked'
                );

            if (selected.length === 0) {

                event.preventDefault();

                return;

            }

            const message =
                selected.length === 1
                    ? '¿Deseas restaurar este usuario?'
                    : '¿Deseas restaurar los ' +
                    selected.length +
                    ' usuarios seleccionados?';

            if (!confirm(message)) {

                event.preventDefault();

            }

        });

</script>

</body>
</html>