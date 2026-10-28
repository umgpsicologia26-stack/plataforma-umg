{{-- PANTALLA DE INTRODUCCIÓN DE VITASAFE --}}
@verbatim
<style>
    html.vs-bloqueado {
        overflow: hidden;
    }

    #vs-splash {
        position: fixed;
        inset: 0;
        z-index: 100001;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 20px 40px;
        box-sizing: border-box;
        overflow-y: auto;
        text-align: center;
        color: #ffffff;
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 40%, #0ea5e9 80%, #22c55e 100%);
        opacity: 1;
        visibility: visible;
        transition: opacity .6s ease, visibility .6s ease;
    }

    #vs-splash.vs-salir {
        opacity: 0;
        visibility: hidden;
    }

    #vs-splash .vs-caja {
        width: 100%;
        max-width: 560px;
        margin: auto;
    }

    #vs-splash .vs-aro {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 26px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #vs-splash .vs-aro::before,
    #vs-splash .vs-aro::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        animation: vs-respirar 6s ease-in-out infinite;
    }

    #vs-splash .vs-aro::before {
        background: rgba(255, 255, 255, .14);
    }

    #vs-splash .vs-aro::after {
        inset: 18px;
        border: 1px solid rgba(255, 255, 255, .45);
        animation-delay: .3s;
    }

    #vs-splash .vs-aro img {
        position: relative;
        z-index: 1;
        width: 84px;
        max-width: 60%;
        filter: drop-shadow(0 8px 20px rgba(0, 0, 0, .35));
    }

    @keyframes vs-respirar {
        0%, 100% { transform: scale(.82); }
        50%      { transform: scale(1.08); }
    }

    #vs-splash h1 {
        margin: 0 0 14px;
        color: #ffffff;
        font-size: clamp(2rem, 1.5rem + 2.5vw, 2.8rem);
        line-height: 1.15;
        text-shadow: 0 8px 24px rgba(0, 0, 0, .25);
    }

    #vs-splash .vs-lema {
        margin: 0 0 14px;
        font-size: clamp(1.05rem, 1rem + .5vw, 1.25rem);
        line-height: 1.6;
        color: #ffffff;
    }

    #vs-splash .vs-detalle {
        margin: 0 0 26px;
        font-size: .95rem;
        line-height: 1.7;
        color: #dbeafe;
    }

    #vs-splash .vs-entrar {
        display: inline-block;
        padding: 14px 34px;
        border: none;
        border-radius: 14px;
        background: #ffffff;
        color: #1e3a8a;
        font: inherit;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .30);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    #vs-splash .vs-entrar:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 36px rgba(15, 23, 42, .38);
    }

    #vs-splash .vs-entrar:focus-visible {
        outline: 3px solid #a5b4fc;
        outline-offset: 3px;
    }

    @media (prefers-reduced-motion: reduce) {
        #vs-splash .vs-aro::before,
        #vs-splash .vs-aro::after {
            animation: none;
        }
        #vs-splash {
            transition: none;
        }
    }
</style>
@endverbatim

<div
    id="vs-splash"
    role="dialog"
    aria-modal="true"
    aria-labelledby="vs-titulo">

    <div class="vs-caja">

        <div class="vs-aro">
            <img src="{{ asset('images/VitaSafe_icono_original.png') }}" alt="Logo VitaSafe">
        </div>

        <h1 id="vs-titulo">VitaSafe</h1>

        <p class="vs-lema">
            Plataforma informática preventiva y de orientación para prevenir el suicidio y acompañar
            a quienes viven situaciones de abuso sexual.
        </p>

        <p class="vs-detalle">
            Aquí encontrarás recursos y acompañamiento para tomar decisiones
            informadas. VitaSafe no sustituye la atención profesional ni los
            servicios de emergencia: si estás en peligro inmediato, llama a
            emergencias de tu localidad.
        </p>

        <button type="button" class="vs-entrar">Entrar</button>

    </div>

</div>

<noscript>
    <style>
        #vs-splash { display: none; }
    </style>
</noscript>

@verbatim
<script>
(function () {

    var el = document.getElementById('vs-splash');
    if (!el) return;

    var yaVisto = false;
    try {
        yaVisto = sessionStorage.getItem('vs_intro') === '1';
    } catch (e) {}

    /* Si ya la vio en esta sesión, se quita sin mostrarla */
    if (yaVisto) {
        el.parentNode.removeChild(el);
        return;
    }

    document.documentElement.classList.add('vs-bloqueado');

    var cerrado = false;

    function salir() {
        if (cerrado) return;
        cerrado = true;

        try {
            sessionStorage.setItem('vs_intro', '1');
        } catch (e) {}

        el.classList.add('vs-salir');
        document.documentElement.classList.remove('vs-bloqueado');

        setTimeout(function () {
            if (el.parentNode) {
                el.parentNode.removeChild(el);
            }
        }, 700);
    }

    var boton = el.querySelector('.vs-entrar');
    if (boton) {
        boton.addEventListener('click', salir);
        boton.focus({ preventScroll: true });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') salir();
    });

})();
</script>
@endverbatim