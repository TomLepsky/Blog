import {
  CreateGuesser,
  ListGuesser,
  EditGuesser,
  FieldGuesser,
  InputGuesser
} from "@api-platform/admin";

import {TextInput, ReferenceInput, SelectInput} from 'react-admin';

const DefaultSuite = (Guesser, props) => {
  return (
    <Guesser {...props}>
      <TextInput multiline={true} source={"name"} />
      <TextInput multiline={true} source={"slug"} />
      <TextInput multiline={true} source={"title"} />
      <TextInput multiline={true} source={"description"} />
      <TextInput multiline={true} source={"ogTitle"} />
      <TextInput multiline={true} source={"ogDescription"} />
      <TextInput multiline={true} source={"keyWords"} />
      <ReferenceInput label="Game" source="name" reference="games">
        <SelectInput/>
      </ReferenceInput>
    </Guesser>
  )
};

export const TagModel = {
  edit: props => DefaultSuite(EditGuesser, props),
  create: props => DefaultSuite(CreateGuesser, props),
  list: props => <ListGuesser {...props}>
    <FieldGuesser source={"name"}/>
    <FieldGuesser source={"slug"}/>
  </ListGuesser>
}
