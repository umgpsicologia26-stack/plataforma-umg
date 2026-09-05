<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Crear evaluación</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background:
                linear-gradient(
                    rgba(8, 15, 35, .96),
                    rgba(8, 15, 35, .98)
                );
            min-height: 100vh;
            color: white;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .card {
            background: rgba(255, 255, 255, .07);
            backdrop-filter: blur(18px);
            border-radius: 28px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, .08);
        }

        .header {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 35px;
        }

        .back {
            color: #7dd3fc;
            text-decoration: none;
            font-size: 32px;
        }

        h1 {
            font-size: 36px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 22px;
            margin-bottom: 20px;
            color: #7dd3fc;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(255,255,255,.06);
            color: white;
            font-family: inherit;
            outline: none;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #7dd3fc;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        select option {
            color: #111827;
            background: white;
        }

        .question-card {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 22px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .question-number {
            font-size: 20px;
            font-weight: 700;
            color: #7dd3fc;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .field {
            margin-bottom: 20px;
        }

        .full {
            grid-column: 1 / -1;
        }

        .required-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .required-container input {
            width: auto;
        }

        .options-container {
            margin-top: 20px;
            display: none;
        }

        .options-title {
            margin-bottom: 12px;
            color: #cbd5e1;
        }

        .option-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .option-row input {
            flex: 1;
        }

        .remove-option {
            width: auto;
            padding: 10px 15px;
            margin: 0;
            background: rgba(239, 68, 68, .2);
            color: #fecaca;
            border: 1px solid rgba(239, 68, 68, .3);
        }

        .remove-option:hover {
            background: rgba(239, 68, 68, .35);
        }

        .buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        button {
            border: none;
            border-radius: 12px;
            padding: 13px 20px;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .add-question {
            width: 100%;
            background: rgba(125, 211, 252, .12);
            color: #7dd3fc;
            border: 1px dashed rgba(125, 211, 252, .5);
            margin-top: 10px;
        }

        .add-question:hover {
            background: rgba(125, 211, 252, .2);
        }

        .add-option {
            background: rgba(125, 211, 252, .12);
            color: #7dd3fc;
        }

        .remove-question {
            background: rgba(239, 68, 68, .15);
            color: #fecaca;
        }

        .save {
            width: 100%;
            margin-top: 30px;
            background: #7dd3fc;
            color: #081323;
            font-size: 17px;
            padding: 17px;
        }

        .save:hover {
            background: #38bdf8;
        }

        .errors {
            background: rgba(239, 68, 68, .12);
            border: 1px solid rgba(239, 68, 68, .3);
            color: #fecaca;
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 25px;
        }

        .errors ul {
            margin-left: 20px;
        }

        .help {
            color: #94a3b8;
            font-size: 13px;
            margin-top: 6px;
        }

        @media (max-width: 700px) {

            body {
                padding: 15px;
            }

            .card {
                padding: 22px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }

            h1 {
                font-size: 27px;
            }

        }

    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <div class="header">

            <a
                href="{{ route('moderator.evaluations') }}"
                class="back"
            >
                ←
            </a>

            <h1>Crear evaluación</h1>

        </div>


        {{-- ERRORES --}}

        @if ($errors->any())

            <div class="errors">

                <strong>
                    Hay errores en el formulario:
                </strong>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('moderator.evaluations.store') }}"
        >

            @csrf


            {{-- INFORMACIÓN GENERAL --}}

            <div class="section">

                <div class="section-title">
                    Información de la evaluación
                </div>


                <div class="field">

                    <label for="title">
                        Título
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        maxlength="200"
                        required
                        placeholder="Escribe el título de la evaluación"
                    >

                </div>


                <div class="field">

                    <label for="description">
                        Descripción
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        placeholder="Describe el propósito de esta evaluación"
                    >{{ old('description') }}</textarea>

                </div>


                <div class="field">

                    <label for="status">
                        Estado
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option value="ACTIVA"
                            {{ old('status', 'ACTIVA') === 'ACTIVA' ? 'selected' : '' }}>
                            Activa
                        </option>

                        <option value="INACTIVA"
                            {{ old('status') === 'INACTIVA' ? 'selected' : '' }}>
                            Inactiva
                        </option>

                    </select>

                </div>

            </div>


            {{-- PREGUNTAS --}}

            <div class="section">

                <div class="section-title">
                    Preguntas
                </div>

                <div id="questions-container"></div>

                <button
                    type="button"
                    class="add-question"
                    onclick="addQuestion()"
                >
                    + Agregar pregunta
                </button>

            </div>


            <button
                type="submit"
                class="save"
            >
                Guardar evaluación
            </button>

        </form>

    </div>

</div>


<script>

let questionIndex = 0;


/*
|--------------------------------------------------------------------------
| Tipos de pregunta
|--------------------------------------------------------------------------
|
| No se agregan respuestas automáticamente.
|
*/

const questionTypes = [

    {
        value: 'TEXTO',
        label: 'Texto'
    },

    {
        value: 'NUMERO',
        label: 'Número entero'
    },

    {
        value: 'DECIMAL',
        label: 'Número decimal'
    },

    {
        value: 'OPCION_UNICA',
        label: 'Opción única'
    },

    {
        value: 'OPCION_MULTIPLE',
        label: 'Opción múltiple'
    },

    {
        value: 'ESCALA',
        label: 'Escala'
    },

    {
        value: 'SI_NO',
        label: 'Sí / No'
    },

    {
        value: 'FECHA',
        label: 'Fecha'
    }

];


function addQuestion()
{

    const container =
        document.getElementById('questions-container');


    const index = questionIndex;


    const card =
        document.createElement('div');

    card.className = 'question-card';

    card.dataset.index = index;


    let typeOptions = '';

    questionTypes.forEach(type => {

        typeOptions += `
            <option value="${type.value}">
                ${type.label}
            </option>
        `;

    });


    card.innerHTML = `

        <div class="question-header">

            <div class="question-number">
                Pregunta <span class="question-number-value">
                    ${index + 1}
                </span>
            </div>

            <button
                type="button"
                class="remove-question"
                onclick="removeQuestion(this)"
            >
                Eliminar
            </button>

        </div>


        <div class="grid">


            <div class="field full">

                <label>
                    Pregunta
                </label>

                <input
                    type="text"
                    name="questions[${index}][question]"
                    required
                    placeholder="Escribe la pregunta"
                >

            </div>


            <div class="field">

                <label>
                    Tipo de pregunta
                </label>

                <select
                    name="questions[${index}][question_type]"
                    class="question-type"
                    onchange="toggleOptions(this)"
                    required
                >

                    ${typeOptions}

                </select>

            </div>


            <div class="field">

                <label>
                    Configuración
                </label>

                <div class="required-container">

                    <input
                        type="hidden"
                        name="questions[${index}][required]"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="questions[${index}][required]"
                        value="1"
                        checked
                    >

                    <span>
                        Pregunta obligatoria
                    </span>

                </div>

            </div>


            <div class="options-container full">

                <div class="options-title">
                    Opciones de respuesta
                </div>

                <div class="options-list"></div>

                <button
                    type="button"
                    class="add-option"
                    onclick="addOption(this)"
                >
                    + Agregar opción
                </button>

                <div class="help">
                    Las opciones son definidas manualmente por el moderador.
                </div>

            </div>

        </div>

    `;


    container.appendChild(card);


    questionIndex++;

    updateQuestionNumbers();

}


/*
|--------------------------------------------------------------------------
| Mostrar / ocultar opciones
|--------------------------------------------------------------------------
*/

function toggleOptions(select)
{

    const card =
        select.closest('.question-card');

    const optionsContainer =
        card.querySelector('.options-container');


    const type =
        select.value;


    const typesWithOptions = [
        'OPCION_UNICA',
        'OPCION_MULTIPLE',
        'ESCALA'
    ];


    if (typesWithOptions.includes(type)) {

        optionsContainer.style.display = 'block';

    } else {

        optionsContainer.style.display = 'none';

    }

}


/*
|--------------------------------------------------------------------------
| Agregar opción
|--------------------------------------------------------------------------
*/

function addOption(button)
{

    const card =
        button.closest('.question-card');

    const optionsList =
        card.querySelector('.options-list');


    const questionIndex =
        card.dataset.index;


    const optionIndex =
        optionsList.children.length;


    const row =
        document.createElement('div');

    row.className = 'option-row';


    row.innerHTML = `

        <input
            type="text"
            name="questions[${questionIndex}][options][${optionIndex}]"
            placeholder="Escribe una opción"
        >

        <button
            type="button"
            class="remove-option"
            onclick="removeOption(this)"
        >
            ×
        </button>

    `;


    optionsList.appendChild(row);

}


/*
|--------------------------------------------------------------------------
| Eliminar opción
|--------------------------------------------------------------------------
*/

function removeOption(button)
{

    const row =
        button.closest('.option-row');

    row.remove();

}


/*
|--------------------------------------------------------------------------
| Eliminar pregunta
|--------------------------------------------------------------------------
*/

function removeQuestion(button)
{

    const card =
        button.closest('.question-card');

    card.remove();

    updateQuestionNumbers();

}


/*
|--------------------------------------------------------------------------
| Actualizar numeración visual
|--------------------------------------------------------------------------
*/

function updateQuestionNumbers()
{

    const questions =
        document.querySelectorAll('.question-card');


    questions.forEach((question, index) => {

        const number =
            question.querySelector(
                '.question-number-value'
            );

        number.textContent = index + 1;

    });

}


/*
|--------------------------------------------------------------------------
| Crear primera pregunta automáticamente
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function () {

        addQuestion();

    }
);

</script>

</body>
</html>