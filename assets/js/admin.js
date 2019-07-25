import React from 'react';
import parseHydraDocumentation from '@api-platform/api-doc-parser/lib/hydra/parseHydraDocumentation';
import { HydraAdmin, hydraClient, fetchHydra as baseFetchHydra } from '@api-platform/admin';
import ReactDOM from 'react-dom';
import authProvider from './src/authProvider';
import { Route, Redirect } from 'react-router-dom';

const entrypoint = document.getElementById('api-entrypoint').innerText;
// Fetch api route with Http Basic auth instead of JWT Bearer system
const fetchHeaders = {"Authorization": `Basic ${btoa(`${localStorage.getItem('username')}:${localStorage.getItem('token')}`)}`};
// original system with JWT
// const fetchHeaders = {'Authorization': `Bearer ${localStorage.getItem('token')}`};
const fetchHydra = (url, options = {}) => baseFetchHydra(url, {
    ...options,
    headers: new Headers(fetchHeaders),
});
const dataProvider = api => hydraClient(api, fetchHydra);
const apiDocumentationParser = entrypoint =>
    parseHydraDocumentation(entrypoint, {
        headers: new Headers(fetchHeaders),
    }).then(
        ({ api }) => ({ api }),
        result => {
            const { api, status } = result;

            if (status === 401) {
                return Promise.resolve({
                    api,
                    status,
                    customRoutes: [
                        <Route path="/" render={() => <Redirect to="/login" />} />, // @todo should be in config or somewhere-else
                    ],
                });
            }

            return Promise.reject(result);
        }
    );

ReactDOM.render(
    <HydraAdmin
        apiDocumentationParser={apiDocumentationParser}
        authProvider={authProvider}
        entrypoint={entrypoint}
        dataProvider={dataProvider}
    />, document.getElementById('api-platform-admin'));
