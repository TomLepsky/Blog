import Head from "next/head";
import {
  HydraAdmin,
  ResourceGuesser,
  EditGuesser,
} from "@api-platform/admin";
import {authProvider, dataProvider} from "../../src/providers";
import {SimpleForm, ReferenceInput, SelectInput, TextInput, required} from 'react-admin';
import {RichTextEditorWrapper} from "../../components/RichTextEditor";
import {ArticleModel, TagModel, ToolModel, MediaModel, GameModel} from "../../src/model";

const AdminLoader = () => {
  if (typeof window !== "undefined") {
    const {HydraAdmin} = require("@api-platform/admin");
    return (
      <HydraAdmin dataProvider={dataProvider} authProvider={authProvider} entrypoint={window.origin}>
        <ResourceGuesser name={'articles'} list={ArticleModel.list} create={ArticleModel.create} edit={ArticleModel.edit}/>
        <ResourceGuesser name={'tags'} list={TagModel.list} create={TagModel.create} edit={TagModel.edit}/>
        <ResourceGuesser name={'tools'} list={ToolModel.list} create={ToolModel.create} edit={ToolModel.edit}/>
        <ResourceGuesser name={'games'} list={GameModel.list} />
        <ResourceGuesser name={'media-objects'} list={MediaModel.list} create={MediaModel.create} edit={MediaModel.edit}/>
      </HydraAdmin>);
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
