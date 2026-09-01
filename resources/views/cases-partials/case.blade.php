<div class="case-item">


<div class="case-item-header">

    <div>
        <div class="case-number">
            {{ $case->case_number }}
        </div>

        <div class="case-date">
            Registrado el
            {{ optional($case->created_at)->format('d/m/Y H:i') }}
        </div>
    </div>

    <div class="status-badge
        @if($case->status === 'Abierto')
            status-open
        @elseif($case->status === 'En seguimiento')
            status-follow
        @elseif($case->status === 'Cerrado')
            status-closed
        @endif
    ">
        {{ $case->status }}
    </div>

</div>


<div class="case-item-body">

    <div class="case-info">

        <div class="info-label">
            Situación reportada
        </div>

        <div class="info-value">
            {{ $case->description }}
        </div>

    </div>


    @if($case->comments && $case->comments->count() > 0)

        <div class="observations">

            <div class="observations-title">
                Observaciones del equipo de moderación
            </div>

            @foreach($case->comments as $comment)

                <div class="observation">

                    <div class="observation-header">

                        <span class="observation-author">

                            @if($comment->user)

                                @if($comment->user->role === 'MODERATOR')

                                    Moderador

                                @else

                                    {{ $comment->user->anonymous_nickname ?? 'Equipo UMG' }}

                                @endif

                            @else

                                Equipo UMG

                            @endif

                        </span>

                        <span class="observation-date">

                            {{ optional($comment->created_at)->format('d/m/Y H:i') }}

                        </span>

                    </div>

                    <div class="observation-text">
                        {{ $comment->comment }}
                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="no-observations">

            @if($case->status === 'Cerrado')

                Este caso fue cerrado y no tiene observaciones adicionales.

            @else

                Aún no hay observaciones de seguimiento para este caso.

            @endif

        </div>

    @endif

</div>

</div>
