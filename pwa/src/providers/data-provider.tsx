import parseHydraDocumentation from "@api-platform/api-doc-parser/lib/hydra/parseHydraDocumentation";
import {Redirect, Route} from "react-router-dom";
import {
  hydraDataProvider as baseHydraDataProvider,
  fetchHydra as baseFetchHydra,
  useIntrospection
} from "@api-platform/admin";

import {API_ENTRYPOINT} from "../../config/entrypoint";

const addAuthorizationHeaders = () => localStorage.getItem("token") ? {
  Authorization: `Bearer ${localStorage.getItem("token")}`,
} : {};

const fetchHydra = (url, options = {}) =>
  baseFetchHydra(url, {
    ...options,
    headers: addAuthorizationHeaders,
  });

const RedirectToLogin = () => {
  const introspect = useIntrospection();

  if (localStorage.getItem("token")) {
    introspect();
    return <></>;
  }
  return <Redirect to="/login"/>;
};

const apiDocumentationParser = async (entrypoint) => {
  try {
    const {api} = await parseHydraDocumentation(entrypoint, {headers: addAuthorizationHeaders});
    return {api};
  } catch (result) {
    if (result.status === 401) {
      localStorage.removeItem("token");

      return {
        api: result.api,
        customRoutes: [
          <Route path="/" component={RedirectToLogin}/>
        ],
      };
    }

    throw result;
  }
};

export const dataProvider = baseHydraDataProvider(`${API_ENTRYPOINT}`, fetchHydra, apiDocumentationParser, true);
