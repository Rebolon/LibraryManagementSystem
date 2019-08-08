// admin/src/authProvider.js
import { AUTH_LOGIN, AUTH_LOGOUT, AUTH_ERROR, AUTH_CHECK } from 'react-admin';

// Change this to be your own authentication token URI.
const authenticationTokenUri = `${document.getElementById('api-entrypoint').innerText}/login`; // @todo should be in config or somewhere-else

export default (type, params) => {
    switch (type) {
        case AUTH_LOGIN:
            const { username, password } = params;
            const request = new Request(authenticationTokenUri, {
                method: 'POST',
                body: JSON.stringify({ username: username, password }),
                headers: new Headers({ 'Content-Type': 'application/json' }),
            });

            return fetch(request)
                .then(response => {
                    if (response.status < 200 || response.status >= 300) throw new Error(response.statusText);

                    return response.json();
                })
                .then(({ token }) => {
                    localStorage.setItem('username', username);
                    localStorage.setItem('token', token); // The token is stored in the browser's local storage
                    window.location.replace('/admin'); // @todo should be in config or somewhere-else
                });

        case AUTH_LOGOUT:
            localStorage.removeItem('username');
            localStorage.removeItem('token');
            break;

        case AUTH_ERROR:
            if (401 === params.status) {
                localStorage.removeItem('username');
                localStorage.removeItem('token');

                return Promise.reject();
            }
            break;

        case AUTH_CHECK:
            return localStorage.getItem('token') ? Promise.resolve() : Promise.reject();

        default:
            return Promise.resolve();
    }
}
