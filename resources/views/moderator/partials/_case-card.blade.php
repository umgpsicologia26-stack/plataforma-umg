@php
    $caseType = strtoupper(trim($caseItem->type ?? ''));
    $status = strtolower(trim($caseItem->status ?? ''));
@endphp

<div class="case-card">

    <div class="case-header">

        <div class="case-main">

            <div class="case-title-label">
                Número de caso
            </div>

            <div class="case-number">
                {{ $caseItem->case_number }}
            </div>

            <div class="case-date">
                Creado el

                {{ $caseItem->created_at
                    ? $caseItem->created_at->format('d/m/Y H:i')
                    : 'No disponible'
                }}
            </div>

        </div>

        <div class="case-badges">

            {{-- TIPO --}}

            @if($caseType === 'SUICIDIO')

                <span class="badge badge-suicide">
                    <i class="fas fa-heart-pulse"></i>
                    Suicidio
                </span>

            @elseif($caseType === 'ABUSO SEXUAL')

                <span class="badge badge-abuse">
                    <i class="fas fa-shield-heart"></i>
                    Abuso sexual
                </span>

            @endif


            {{-- ESTADO --}}

            @if($status === 'abierto')

                <span class="badge badge-open">
                    <i class="fas fa-folder-open"></i>
                    Abierto
                </span>

            @elseif($status === 'en seguimiento')

            <span class="badge badge-follow">
                <i class="fas fa-spinner"></i>
            En seguimiento
        </span>

            @elseif($status === 'cerrado')

                <span class="badge badge-closed">
                    <i class="fas fa-lock"></i>
                    Cerrado
                </span>

            @else

                <span class="badge badge-open">
                    {{ $caseItem->status ?? 'Sin estado' }}
                </span>

            @endif

        </div>

    </div>


    {{-- INFORMACIÓN --}}

    <div class="case-info">

        <div class="info-box">

            <span class="info-label">
                Número de caso
            </span>

            <span class="info-value">
                {{ $caseItem->case_number }}
            </span>

        </div>


        <div class="info-box">

            <span class="info-label">
                Tipo de caso
            </span>

            <span class="info-value">

                @if($caseType === 'SUICIDIO')
                    Suicidio
                @elseif($caseType === 'ABUSO SEXUAL')
                    Abuso sexual
                @else
                    No especificado
                @endif

            </span>

        </div>


        <div class="info-box">

            <span class="info-label">
                Estado actual
            </span>

            <span class="info-value">

                @if($status === 'abierto')
                    Abierto
                @elseif($status === 'en seguimiento')
                    En seguimiento
                @elseif($status === 'cerrado')
                    Cerrado
                @else
                    {{ $caseItem->status ?? 'Sin estado' }}
                @endif

            </span>

        </div>


        <div class="info-box">

            <span class="info-label">
                Usuario
            </span>

            <span class="info-value">

                @if($caseItem->user)

                    {{ $caseItem->user->anonymous_nickname
                        ?? $caseItem->user->full_name
                        ?? trim(
                            ($caseItem->user->first_name ?? '') . ' ' .
                            ($caseItem->user->last_name ?? '')
                        )
                        ?: 'Usuario'
                    }}

                @else

                    Usuario

                @endif

            </span>

        </div>


        <div class="info-box">

            <span class="info-label">
                Fecha de creación
            </span>

            <span class="info-value">

                {{ $caseItem->created_at
                    ? $caseItem->created_at->format('d/m/Y H:i')
                    : 'No disponible'
                }}

            </span>

        </div>


        <div class="info-box">

            <span class="info-label">
                Última actualización
            </span>

            <span class="info-value">

                {{ $caseItem->updated_at
                    ? $caseItem->updated_at->format('d/m/Y H:i')
                    : 'No disponible'
                }}

            </span>

        </div>


        <div class="info-box">

            <span class="info-label">
                Moderador asignado
            </span>

            <span class="info-value">

                @if($caseItem->moderator)

                    {{ $caseItem->moderator->full_name
                        ?? trim(
                            ($caseItem->moderator->first_name ?? '') . ' ' .
                            ($caseItem->moderator->last_name ?? '')
                        )
                        ?: 'Moderador'
                    }}

                @else

                    Sin asignar

                @endif

            </span>

        </div>

    </div>


    {{-- DESCRIPCIÓN --}}

    <div class="description">

        <div class="description-title">

            <i class="fas fa-file-lines"></i>

            Situación reportada

        </div>

        <div class="description-text">

            {{ $caseItem->description ?? 'Sin descripción registrada.' }}

        </div>

    </div>

    {{-- ÚLTIMA OBSERVACIÓN --}}

@if($caseItem->comments && $caseItem->comments->count() > 0)

    @php
        $lastComment = $caseItem->comments->sortByDesc('created_at')->first();
    @endphp

    <div class="description">

        <div class="description-title">

            <i class="fas fa-comment-dots"></i>

            Última observación

        </div>

        <div class="description-text">

            {{ $lastComment->comment }}

        </div>

    </div>

@endif

    {{-- FOOTER --}}

    <div class="case-footer">

        <div class="case-user">

            <div class="user-icon">

                <i class="fas fa-user-shield"></i>

            </div>

            <span>
                Caso asignado a este moderador
            </span>

        </div>

        <a
            href="{{ route('moderator.case', ['id' => $caseItem->id]) }}"
            class="btn-view">

            <i class="fas fa-eye"></i>

            Ver y gestionar caso

        </a>

    </div>

</div>
