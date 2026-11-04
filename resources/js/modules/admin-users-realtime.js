const tableBody = document.getElementById('registeredUsersTableBody');
const countElement = document.getElementById('registeredUsersCount');

if (tableBody && countElement && window.Echo) {
    let refreshInProgress = false;
    let refreshPending = false;

    async function refreshRegisteredUsers() {
        if (refreshInProgress) {
            refreshPending = true;
            return;
        }

        refreshInProgress = true;

        try {
            const response = await fetch(window.location.href, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                },
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const html = await response.text();
            const parsed = new DOMParser().parseFromString(html, 'text/html');

            const newBody = parsed.getElementById('registeredUsersTableBody');
            const newCount = parsed.getElementById('registeredUsersCount');

            if (!newBody || !newCount) {
                throw new Error('No se encontraron los elementos de la tabla.');
            }

            tableBody.innerHTML = newBody.innerHTML;
            countElement.textContent = newCount.textContent.trim();

        } catch (error) {
            console.error(
                'No fue posible actualizar la lista de usuarios:',
                error
            );
        } finally {
            refreshInProgress = false;

            if (refreshPending) {
                refreshPending = false;
                refreshRegisteredUsers();
            }
        }
    }

    window.Echo.private('admins')
        .listen('.admin.user.registered', () => {
            refreshRegisteredUsers();
        });
}