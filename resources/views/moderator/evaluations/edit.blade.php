<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar evaluación | Panel del Moderador</title>
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet"
>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
>
<style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #f4f7fb;
        min-height: 100vh;
        color: #1e293b;
    }

    .navbar {
        width: 95%;
        max-width: 1400px;
        margin: 20px auto;
        padding: 18px 30px;
        background: white;
        border-radius: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand-icon {
        width: 48px;
        height: 48px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #2563eb;
        color: white;
        font-size: 22px;
    }

    .brand h2 {
        font-size: 20px;
        color: #1e3a8a;
    }

    .brand span {
        display: block;
        font-size: 12px;
        color: #64748b;
    }

    .logout-btn {
        border: none;
        background: #ef4444;
        color: white;
        padding: 11px 20px;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .logout-btn:hover {
        background: #dc2626;
    }

    .container {
        width: 95%;
        max-width: 1100px;
        margin: 40px auto 60px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 32px;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .page-header p {
        color: #64748b;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 18px;
        border: none;
        border-radius: 12px;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-secondary {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-secondary:hover {
        background: #cbd5e1;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .card {
        background: white;
        border-radius: 25px;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 15px 40px rgba(0,0,0,.08);
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
    }

    .card-title-icon {
        width: 45px;
        height: 45px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #2563eb;
    }

    .card-title h2 {
        font-size: 20px;
        color: #0f172a;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .required-mark {
        color: #ef4444;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 13px 15px;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        color: #1e293b;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        outline: none;
        transition: .2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2563eb;
        background: white;
        box-shadow: 0 0 0 3px rgba(37,99,235,.10);
    }

    textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .question-card {
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 20px;
        background: #f8fafc;
        position: relative;
    }

    .question-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .question-number {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #1e3a8a;
        font-size: 14px;
        font-weight: 800;
    }

    .question-number-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #dbeafe;
        color: #2563eb;
    }

    .remove-question {
        border: none;
        background: #fee2e2;
        color: #dc2626;
        padding: 8px 12px;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .remove-question:hover {
        background: #fecaca;
    }

    .question-grid {
        display: grid;
        grid-template-columns: 1fr 240px;
        gap: 18px;
    }

    .required-container {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 0;
    }

    .required-container input {
        width: 18px;
        height: 18px;
        accent-color: #2563eb;
        cursor: pointer;
    }

    .required-container label {
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .options-section {
        margin-top: 18px;
        padding: 18px;
        border-radius: 15px;
        background: white;
        border: 1px solid #e2e8f0;
    }

    .options-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .options-title span {
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .add-option {
        border: none;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 7px 11px;
        border-radius: 9px;
        font-family: 'Poppins', sans-serif;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .option-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .option-row:last-child {
        margin-bottom: 0;
    }

    .option-input {
        flex: 1;
    }

    .remove-option {
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 10px;
        background: #fee2e2;
        color: #dc2626;
        cursor: pointer;
        transition: .2s;
    }

    .remove-option:hover {
        background: #fecaca;
    }

    .empty-options {
        color: #94a3b8;
        font-size: 12px;
        font-style: italic;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 30px;
    }

    .form-actions-right {
        display: flex;
        gap: 10px;
    }

    .error-box {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 15px;
        padding: 18px;
        margin-bottom: 25px;
        font-size: 13px;
    }

    .error-box ul {
        margin: 8px 0 0 20px;
    }

    .error-box li {
        margin-bottom: 4px;
    }

    .question-help {
        color: #64748b;
        font-size: 11px;
        margin-top: 6px;
    }

    @media(max-width: 800px) {

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .question-grid {
            grid-template-columns: 1fr;
        }

    }

    @media(max-width: 600px) {

        .navbar {
            width: 92%;
            padding: 16px 20px;
        }

        .brand h2 {
            font-size: 16px;
        }

        .brand span {
            font-size: 10px;
        }

        .logout-btn {
            padding: 9px 12px;
            font-size: 11px;
        }

        .container {
            width: 92%;
            margin-top: 30px;
        }

        .page-header h1 {
            font-size: 26px;
        }

        .card {
            padding: 20px;
        }

        .question-card {
            padding: 18px;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .form-actions-right {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
        }

    }

</style>
</head>

<body>

<nav class="navbar">

<div class="brand">

<div class="brand-icon">

    <i class="fas fa-shield-halved"></i>

</div>

<div>

    <h2>
        Panel del Moderador
    </h2>

    <span>
        Plataforma UMG Xela
    </span>

</div>

</div>

<form
    method="POST"
    action="{{ url('/logout') }}">

@csrf

<button
    type="submit"
    class="logout-btn">

    <i class="fas fa-right-from-bracket"></i>

    Cerrar sesión

</button>

</form>

</nav>

<main class="container">

<div class="page-header">

<div>

    <h1>
        Editar evaluación
    </h1>

    <p>
        Modifica la información, preguntas y opciones de esta evaluación.
    </p>

</div>

<a
    href="{{ route('moderator.evaluations') }}"
    class="btn btn-secondary">

    <i class="fas fa-arrow-left"></i>

    Volver

</a>

</div>

@if($errors->any())

<div class="error-box">

    <strong>
        <i class="fas fa-exclamation-circle"></i>
        Se encontraron algunos errores:
    </strong>

    <ul>

        @foreach($errors->all() as $error)

            <li>
                {{ $error }}
            </li>

        @endforeach

    </ul>

</div>

@endif

<form
    method="POST"
    action="{{ route('moderator.evaluations.update', $evaluacion->uuid) }}"
    id="evaluationForm">

@csrf

@method('PUT')

<div class="card">

    <div class="card-title">

        <div class="card-title-icon">

            <i class="fas fa-clipboard-list"></i>

        </div>

        <h2>
            Información general
        </h2>

    </div>

    <div class="form-group">

        <label
            for="title"
            class="form-label">

            Título
            <span class="required-mark">*</span>

        </label>

        <input
            type="text"
            id="title"
            name="title"
            class="form-control"
            value="{{ old('title', $evaluacion->title) }}"
            maxlength="200"
            required>

    </div>

    <div class="form-group">

        <label
            for="description"
            class="form-label">

            Descripción

        </label>

        <textarea
            id="description"
            name="description"
            class="form-control"
            maxlength="5000"
            placeholder="Describe el propósito de esta evaluación...">{{ old('description', $evaluacion->description) }}</textarea>

    </div>

    <div class="form-group">

        <label
            for="status"
            class="form-label">

            Estado

        </label>

        <select
            id="status"
            name="status"
            class="form-select">

            <option
                value="ACTIVA"
                {{ old('status', $evaluacion->status) === 'ACTIVA' ? 'selected' : '' }}>

                ACTIVA

            </option>

            <option
                value="INACTIVA"
                {{ old('status', $evaluacion->status) === 'INACTIVA' ? 'selected' : '' }}>

                INACTIVA

            </option>

        </select>

    </div>

</div>

<div class="card">

    <div class="card-title">

        <div class="card-title-icon">

            <i class="fas fa-list-check"></i>

        </div>

        <h2>
            Preguntas
        </h2>

    </div>

    <div id="questionsContainer">

        @foreach($evaluacion->preguntas as $index => $pregunta)

            @php

                $questionType = old(
                    "questions.$index.question_type",
                    $pregunta->question_type
                );

                $options = old(
                    "questions.$index.options",
                    is_array($pregunta->options)
                        ? $pregunta->options
                        : []
                );

            @endphp

            <div
                class="question-card"
                data-question-index="{{ $index }}">

                <div class="question-header">

                    <div class="question-number">

                        <div class="question-number-icon">

                            <i class="fas fa-question"></i>

                        </div>

                        <span>

                            Pregunta

                            <span class="question-number-value">
                                {{ $index + 1 }}
                            </span>

                        </span>

                    </div>

                    <button
                        type="button"
                        class="remove-question"
                        onclick="removeQuestion(this)">

                        <i class="fas fa-trash"></i>

                        Eliminar

                    </button>

                </div>

                <input
                    type="hidden"
                    name="questions[{{ $index }}][uuid]"
                    value="{{ $pregunta->uuid }}">

                <input
                    type="hidden"
                    class="question-order"
                    name="questions[{{ $index }}][question_order]"
                    value="{{ $index + 1 }}">

                <div class="question-grid">

                    <div class="form-group">

                        <label class="form-label">

                            Pregunta
                            <span class="required-mark">*</span>

                        </label>

                        <textarea
                            name="questions[{{ $index }}][question]"
                            class="form-control"
                            rows="3"
                            required>{{ old("questions.$index.question", $pregunta->question) }}</textarea>

                    </div>

                    <div>

                        <div class="form-group">

                            <label class="form-label">

                                Tipo de respuesta
                                <span class="required-mark">*</span>

                            </label>

                            <select
                                name="questions[{{ $index }}][question_type]"
                                class="form-select question-type"
                                onchange="toggleOptions(this)"
                                required>

                                <option value="TEXTO"
                                    {{ $questionType === 'TEXTO' ? 'selected' : '' }}>
                                    Texto
                                </option>

                                <option value="NUMERO"
                                    {{ $questionType === 'NUMERO' ? 'selected' : '' }}>
                                    Número entero
                                </option>

                                <option value="DECIMAL"
                                    {{ $questionType === 'DECIMAL' ? 'selected' : '' }}>
                                    Número decimal
                                </option>

                                <option value="OPCION_UNICA"
                                    {{ $questionType === 'OPCION_UNICA' ? 'selected' : '' }}>
                                    Opción única
                                </option>

                                <option value="OPCION_MULTIPLE"
                                    {{ $questionType === 'OPCION_MULTIPLE' ? 'selected' : '' }}>
                                    Opción múltiple
                                </option>

                                <option value="ESCALA"
                                    {{ $questionType === 'ESCALA' ? 'selected' : '' }}>
                                    Escala
                                </option>

                                <option value="SI_NO"
                                    {{ $questionType === 'SI_NO' ? 'selected' : '' }}>
                                    Sí / No
                                </option>

                                <option value="FECHA"
                                    {{ $questionType === 'FECHA' ? 'selected' : '' }}>
                                    Fecha
                                </option>

                            </select>

                        </div>

                        <div class="required-container">

                            <input
                                type="hidden"
                                name="questions[{{ $index }}][required]"
                                value="0">

                            <input
                                type="checkbox"
                                id="required_{{ $index }}"
                                name="questions[{{ $index }}][required]"
                                value="1"
                                {{ old("questions.$index.required", $pregunta->required) ? 'checked' : '' }}>

                            <label for="required_{{ $index }}">

                                Pregunta obligatoria

                            </label>

                        </div>

                    </div>

                </div>

                <div
                    class="options-section options-container"
                    style="{{ in_array($questionType, ['OPCION_UNICA', 'OPCION_MULTIPLE', 'ESCALA']) ? '' : 'display:none;' }}">

                    <div class="options-title">

                        <span>

                            <i class="fas fa-list"></i>

                            Opciones de respuesta

                        </span>

                        <button
                            type="button"
                            class="add-option"
                            onclick="addOption(this)">

                            <i class="fas fa-plus"></i>

                            Agregar opción

                        </button>

                    </div>

                    <div class="options-list">

                        @forelse($options as $option)

                            <div class="option-row">

                                <input
                                    type="text"
                                    name="questions[{{ $index }}][options][]"
                                    class="form-control option-input"
                                    value="{{ $option }}"
                                    placeholder="Escribe una opción"
                                    maxlength="500">

                                <button
                                    type="button"
                                    class="remove-option"
                                    onclick="removeOption(this)"
                                    title="Eliminar opción">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </div>

                        @empty

                            <div class="empty-options">

                                No hay opciones configuradas.
                                El moderador debe agregarlas manualmente.

                            </div>

                        @endforelse

                    </div>

                </div>

                <p class="question-help">

                    El sistema conservará únicamente las opciones definidas por el moderador.

                </p>

            </div>

        @endforeach

    </div>

    <button
        type="button"
        class="btn btn-primary"
        onclick="addQuestion()">

        <i class="fas fa-plus"></i>

        Agregar pregunta

    </button>

</div>

<div class="form-actions">

    <a
        href="{{ route('moderator.evaluations') }}"
        class="btn btn-secondary">

        <i class="fas fa-xmark"></i>

        Cancelar

    </a>

    <div class="form-actions-right">

        <button
            type="submit"
            class="btn btn-primary">

            <i class="fas fa-save"></i>

            Guardar cambios

        </button>

    </div>

</div>

</form>

</main>

<script>

    let questionIndex = {{ $evaluacion->preguntas->count() }};


    function updateQuestionNumbers() {

        const questions =
            document.querySelectorAll('.question-card');

        questions.forEach(function(question, index) {

            const number =
                question.querySelector('.question-number-value');

            if (number) {
                number.textContent = index + 1;
            }

            const order =
                question.querySelector('.question-order');

            if (order) {
                order.value = index + 1;
            }

        });

    }


    /*
     * Reorganiza los índices de las preguntas después
     * de agregar o eliminar una pregunta.
     */
    function reindexQuestions() {

        const questions =
            document.querySelectorAll('.question-card');

        questions.forEach(function(question, index) {

            question.dataset.questionIndex = index;

            const elements =
                question.querySelectorAll('[name]');

            elements.forEach(function(element) {

                const name =
                    element.getAttribute('name');

                if (!name) {
                    return;
                }

                const newName =
                    name.replace(
                        /questions\[\d+\]/,
                        'questions[' + index + ']'
                    );

                element.setAttribute(
                    'name',
                    newName
                );

            });


            const order =
                question.querySelector('.question-order');

            if (order) {
                order.value = index + 1;
            }


            const checkbox =
                question.querySelector(
                    '.required-container input[type="checkbox"]'
                );

            const label =
                question.querySelector(
                    '.required-container label'
                );

            if (checkbox) {

                checkbox.id =
                    'required_' + index;

            }

            if (label) {

                label.setAttribute(
                    'for',
                    'required_' + index
                );

            }

        });

        updateQuestionNumbers();

    }


    function addQuestion() {

        const container =
            document.getElementById('questionsContainer');

        const index = questionIndex++;

        const question =
            document.createElement('div');

        question.className = 'question-card';

        question.dataset.questionIndex = index;

        question.innerHTML = `

            <div class="question-header">

                <div class="question-number">

                    <div class="question-number-icon">

                        <i class="fas fa-question"></i>

                    </div>

                    <span>

                        Pregunta

                        <span class="question-number-value"></span>

                    </span>

                </div>

                <button
                    type="button"
                    class="remove-question"
                    onclick="removeQuestion(this)">

                    <i class="fas fa-trash"></i>

                    Eliminar

                </button>

            </div>


            <input
                type="hidden"
                class="question-order"
                name="questions[${index}][question_order]"
                value="">


            <div class="question-grid">

                <div class="form-group">

                    <label class="form-label">

                        Pregunta

                        <span class="required-mark">*</span>

                    </label>

                    <textarea
                        name="questions[${index}][question]"
                        class="form-control"
                        rows="3"
                        placeholder="Escribe la pregunta..."
                        required></textarea>

                </div>


                <div>

                    <div class="form-group">

                        <label class="form-label">

                            Tipo de respuesta

                            <span class="required-mark">*</span>

                        </label>

                        <select
                            name="questions[${index}][question_type]"
                            class="form-select question-type"
                            onchange="toggleOptions(this)"
                            required>

                            <option value="TEXTO">
                                Texto
                            </option>

                            <option value="NUMERO">
                                Número entero
                            </option>

                            <option value="DECIMAL">
                                Número decimal
                            </option>

                            <option value="OPCION_UNICA">
                                Opción única
                            </option>

                            <option value="OPCION_MULTIPLE">
                                Opción múltiple
                            </option>

                            <option value="ESCALA">
                                Escala
                            </option>

                            <option value="SI_NO">
                                Sí / No
                            </option>

                            <option value="FECHA">
                                Fecha
                            </option>

                        </select>

                    </div>


                    <div class="required-container">

                        <input
                            type="hidden"
                            name="questions[${index}][required]"
                            value="0">

                        <input
                            type="checkbox"
                            id="required_${index}"
                            name="questions[${index}][required]"
                            value="1">

                        <label for="required_${index}">

                            Pregunta obligatoria

                        </label>

                    </div>

                </div>

            </div>


            <div
                class="options-section options-container"
                style="display:none;">

                <div class="options-title">

                    <span>

                        <i class="fas fa-list"></i>

                        Opciones de respuesta

                    </span>

                    <button
                        type="button"
                        class="add-option"
                        onclick="addOption(this)">

                        <i class="fas fa-plus"></i>

                        Agregar opción

                    </button>

                </div>


                <div class="options-list">

                    <div class="empty-options">

                        No hay opciones configuradas.
                        Agrega las opciones manualmente.

                    </div>

                </div>

            </div>


            <p class="question-help">

                El sistema no agregará opciones automáticamente.

            </p>

        `;

        container.appendChild(question);

        reindexQuestions();

    }


    function removeQuestion(button) {

        const questions =
            document.querySelectorAll('.question-card');

        if (questions.length <= 1) {

            alert(
                'La evaluación debe tener al menos una pregunta.'
            );

            return;

        }

        const question =
            button.closest('.question-card');

        question.remove();

        reindexQuestions();

    }


    function toggleOptions(select) {

        const question =
            select.closest('.question-card');

        const optionsContainer =
            question.querySelector('.options-container');

        const type = select.value;

        const optionTypes = [
            'OPCION_UNICA',
            'OPCION_MULTIPLE',
            'ESCALA'
        ];

        if (optionTypes.includes(type)) {

            optionsContainer.style.display = 'block';

        } else {

            optionsContainer.style.display = 'none';

        }

    }


    function addOption(button) {

        const question =
            button.closest('.question-card');

        const optionsList =
            question.querySelector('.options-list');

        const questionIndexValue =
            question.dataset.questionIndex;

        const empty =
            optionsList.querySelector('.empty-options');

        if (empty) {
            empty.remove();
        }

        const optionRow =
            document.createElement('div');

        optionRow.className = 'option-row';

        optionRow.innerHTML = `

            <input
                type="text"
                name="questions[${questionIndexValue}][options][]"
                class="form-control option-input"
                placeholder="Escribe una opción"
                maxlength="500">

            <button
                type="button"
                class="remove-option"
                onclick="removeOption(this)"
                title="Eliminar opción">

                <i class="fas fa-trash"></i>

            </button>

        `;

        optionsList.appendChild(optionRow);

    }


    function removeOption(button) {

        const optionsList =
            button.closest('.options-list');

        button.closest('.option-row').remove();

        if (
            optionsList.querySelectorAll('.option-row').length === 0
        ) {

            optionsList.innerHTML = `

                <div class="empty-options">

                    No hay opciones configuradas.
                    Agrega las opciones manualmente.

                </div>

            `;

        }

    }


    document.addEventListener(
        'DOMContentLoaded',
        function () {

            document
                .querySelectorAll('.question-type')
                .forEach(function (select) {

                    toggleOptions(select);

                });

            reindexQuestions();

        }
    );


    document
        .getElementById('evaluationForm')
        .addEventListener(
            'submit',
            function (event) {

                const questions =
                    document.querySelectorAll('.question-card');

                if (questions.length === 0) {

                    event.preventDefault();

                    alert(
                        'La evaluación debe tener al menos una pregunta.'
                    );

                    return;

                }


                let valid = true;


                questions.forEach(function (question) {

                    const type =
                        question
                            .querySelector('.question-type')
                            .value;


                    const optionTypes = [
                        'OPCION_UNICA',
                        'OPCION_MULTIPLE',
                        'ESCALA'
                    ];


                    if (optionTypes.includes(type)) {

                        const options =
                            question.querySelectorAll(
                                '.option-row .option-input'
                            );


                        if (options.length === 0) {

                            valid = false;

                            return;

                        }


                        options.forEach(function (option) {

                            if (
                                option.value.trim() === ''
                            ) {

                                valid = false;

                            }

                        });

                    }

                });


                if (!valid) {

                    event.preventDefault();

                    alert(
                        'Las preguntas de opción única, opción múltiple y escala deben tener al menos una opción definida por el moderador.'
                    );

                    return;

                }


                reindexQuestions();

            }
        );


</script>

</body>

</html>