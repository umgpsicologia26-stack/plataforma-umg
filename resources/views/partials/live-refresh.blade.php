{{-- Utilidades de actualización en vivo. Sin dependencias. El evento de Echo solo es una SEÑAL: los datos se vuelven a pedir por HTTP autenticado, así el servidor sigue aplicando permisos, filtros de privacidad y descifrado, y nunca se duplican elementos. --}} 
<script>
 window.umgLive = window.umgLive || (function () { 
function whenEchoReady(callback) {  
    function run() {  
        if (!window.Echo) {  
            console.error('Laravel Echo no está inicializado en esta página.');  
            return;  
        }  
        callback(window.Echo);  
    }

    if (document.readyState === 'complete') {  
        run();  
    } else {  
        window.addEventListener('load', run);  
    }  
}

function listen(echo, channelName, eventName, handler) {  
    echo.private(channelName)  
        .listen(eventName, handler)  
        .error(function (error) {  
            console.error('No se pudo suscribir al canal ' + channelName, error);  
        });  
}

function swapContent(selector, doc) {  
    const current = document.querySelector(selector);  
    const fresh = doc.querySelector(selector);

    if (current && fresh && current.innerHTML !== fresh.innerHTML) {  
        current.innerHTML = fresh.innerHTML;  
    }  
}

function createRefresher(options) {  
    const url = options.url || window.location.href;  
    const delay = options.delay || 250;  
    let timer = null;  
    let busy = false;  
    let pending = false;

    async function run() {  
        if (document.hidden || busy) {  
            pending = true;  
            return;  
        }

        busy = true;  
        pending = false;

        try {  
            const response = await fetch(url, {  
                credentials: 'same-origin',  
                cache: 'no-store',  
                headers: {  
                    'Accept': 'text/html',  
                    'X-Requested-With': 'XMLHttpRequest'  
                }  
            });

            // Sesión caducada o redirección: no tocar la pantalla.  
            if (!response.ok || response.redirected) {  
                return;  
            }

            const html = await response.text();  
            options.apply(new DOMParser().parseFromString(html, 'text/html'));  
        } catch (error) {  
            console.error('Error al actualizar la vista:', error);  
        } finally {  
            busy = false;

            if (pending && !document.hidden) {  
                schedule();  
            }  
        }  
    }

    function schedule() {  
        clearTimeout(timer);  
        timer = setTimeout(run, delay);  
    }

    document.addEventListener('visibilitychange', function () {  
        if (!document.hidden && pending) {  
            schedule();  
        }  
    });

    return { trigger: schedule };  
}

// Si la conexión de Reverb se cae y vuelve, se refresca una vez  
// para recuperar lo que pudo perderse mientras estuvo caída.  
function onReconnect(echo, callback) {  
    const pusher = echo.connector && echo.connector.pusher;

    if (!pusher || !pusher.connection) {  
        return;  
    }

    let wasDown = false;

    pusher.connection.bind('state_change', function (states) {  
        if (['unavailable', 'failed', 'disconnected'].indexOf(states.current) !== -1) {  
            wasDown = true;  
        } else if (states.current === 'connected' && wasDown) {  
            wasDown = false;  
            callback();  
        }  
    });  
}

return {  
    whenEchoReady: whenEchoReady,  
    listen: listen,  
    swapContent: swapContent,  
    createRefresher: createRefresher,  
    onReconnect: onReconnect  
};  
})();
</script>