import Head from "next/head";
import {HydraAdmin} from "@api-platform/admin";
import {authProvider, dataProvider} from "../../src/providers";


const AdminLoader = () => {
  if (typeof window !== "undefined") {
    const {HydraAdmin} = require("@api-platform/admin");
    return <HydraAdmin dataProvider={dataProvider} authProvider={authProvider} entrypoint={window.origin}/>;
  }

  return <></>;
};

const Admin = () => (
  <>
    <Head>
      <title>API Platform Admin</title>
    </Head>

    <AdminLoader/>
  </>
);
export default Admin;
