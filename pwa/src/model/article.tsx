import {ConfiguredRichText} from "../../components/RichTextEditor";
import {
  CreateGuesser,
  ListGuesser,
  EditGuesser,
  FieldGuesser,
  InputGuesser
} from "@api-platform/admin";

import { ReferenceInput } from "react-admin";

import {TextInput, AutocompleteArrayInput} from 'react-admin';

const DefaultSuite = (Guesser, props) => {
  return (
    <Guesser {...props}>
      <TextInput multiline={true} source={"header"}/>
      <ConfiguredRichText source={'content'} validation={{required: true}}/>
      <TextInput multiline={true} source={"slug"}/>
      <TextInput multiline={true} source={"title"}/>
      <TextInput multiline={true} source={"description"}/>
      <TextInput multiline={true} source={"ogTitle"}/>
      <TextInput multiline={true} source={"ogDescription"}/>
      <TextInput multiline={true} source={"keyWords"}/>
      <ReferenceInput label="Tags" source="tags" reference="articles">
        <AutocompleteArrayInput source="name" />
      </ReferenceInput>
    </Guesser>
  )
};

export const ArticleModel = {
  edit: props => DefaultSuite(EditGuesser, props),
  create: props => DefaultSuite(CreateGuesser, props),
  list: props => <ListGuesser {...props}>
    <FieldGuesser source={"header"}/>
    <FieldGuesser source={"slug"}/>
    <FieldGuesser source={"tags"}/>
  </ListGuesser>
}
