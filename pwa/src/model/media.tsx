import {
  CreateGuesser,
  ListGuesser,
  EditGuesser,
  FieldGuesser,
  InputGuesser
} from "@api-platform/admin";

import { FileField, FileInput } from "react-admin";


const DefaultSuite = (Guesser, props) => {
  return (
    <Guesser {...props}>
      <FileInput source="file">
        <FileField source="src" title="title"/>
      </FileInput>
      <InputGuesser source={"fileName"} addLabel={true} />
    </Guesser>
  )
}

export const MediaModel = {
  edit: props => DefaultSuite(EditGuesser, props),
  create: props => DefaultSuite(CreateGuesser, props),
  list: props => <ListGuesser {...props}>
    <FieldGuesser source={"name"}/>
    <FieldGuesser source={"updatedAt"}/>
  </ListGuesser>
}



