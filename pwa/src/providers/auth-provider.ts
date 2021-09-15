import {API_ENTRYPOINT} from "../../config/entrypoint";

export const authProvider = {
  login: ({username, password}) => {
    const request = new Request(`${API_ENTRYPOINT}/api/login`, {
      method: 'POST',
      body: JSON.stringify({login: username, password}),
      headers: new Headers({'Content-Type': 'application/json'}),
    });

    return fetch(request)
      .then(response => {
        if (response.status < 200 || response.status >= 300) {
          throw new Error(response.statusText);
        }

        return response.json();
      })
      .then(auth => {
        localStorage.setItem('auth', JSON.stringify(auth));
      })
      .catch(() => {
        throw new Error('Network error')
      });
  },
  checkError: (error) => {
    const status = error.status;

    if (status === 401 || status === 403) {
      localStorage.removeItem('auth');
      return Promise.reject();
    }

    return Promise.resolve();
  },
  checkAuth: () => localStorage.getItem('auth') ? Promise.resolve() : Promise.reject({redirectTo: '/login'}),
  logout: () => {
    localStorage.removeItem('auth');

    return Promise.resolve();
  },
  getPermissions: () => {
    const role = localStorage.getItem('permissions');

    return role ? Promise.resolve(role) : Promise.reject();
  }
};
