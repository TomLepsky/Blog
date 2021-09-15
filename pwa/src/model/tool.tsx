import {
  CreateGuesser,
  ListGuesser,
  EditGuesser,
  FieldGuesser
} from "@api-platform/admin";

const DefaultSuite = (Guesser, props) => {
  return (
    <Guesser {...props}>
      <FieldGuesser multiline={true} source={"name"}/>
      <FieldGuesser source={"mediaObject"}/>
      <FieldGuesser multiline={true} source={"href"}/>
      <FieldGuesser source={"game"}/>
    </Guesser>
  )
};

export const ToolModel = {
  edit: props => DefaultSuite(EditGuesser, props),
  create: props => DefaultSuite(CreateGuesser, props),
  list: props => <ListGuesser {...props}>
    <FieldGuesser source={"name"}/>
  </ListGuesser>
}
