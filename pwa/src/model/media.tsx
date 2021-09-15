import {
  CreateGuesser,
  ListGuesser,
  EditGuesser,
  FieldGuesser
} from "@api-platform/admin";

import { FileField, FileInput } from "react-admin";


const DefaultSuite = (Guesser, props) => {
  return (
    <Guesser {...props}>
      <FileInput source="file">
        <FileField source="src" title="title"/>
      </FileInput>
      <FieldGuesser source={"fileName"} addLabel={true} />
      <FieldGuesser source={"name"} addLabel={true} />
      <FieldGuesser source={"original"} addLabel={true} />
      <FieldGuesser source={"placeholder"} addLabel={true} />
      <FieldGuesser source={"updatedAt"} addLabel={true} />
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



