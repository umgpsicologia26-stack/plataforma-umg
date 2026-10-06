(function () {

    const TIMEOUT = 15 * 60 * 1000; // 15 minutos

    let inactivityTimer;

    function resetInactivityTimer() {

        clearTimeout(inactivityTimer);

        inactivityTimer = setTimeout(function () {

            console.log(
                'Han transcurrido 15 minutos sin actividad.'
            );

        }, TIMEOUT);
    }

    [
        'mousemove',
        'mousedown',
        'keydown',
        'touchstart',
        'scroll',
        'click'
    ].forEach(function (eventName) {

        document.addEventListener(
            eventName,
            resetInactivityTimer,
            {
                passive: true
            }
        );

    });

    resetInactivityTimer();

})();