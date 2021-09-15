import {ConfiguredRichText} from "../../components/RichTextEditor";
import {
  CreateGuesser,
  ListGuesser,
  EditGuesser,
  FieldGuesser,
} from "@api-platform/admin";


const DefaultSuite = (Guesser, props) => {
  return (
    <Guesser {...props}>
    </Guesser>
  )
};

export const GameModel = {
  edit: props => DefaultSuite(EditGuesser, props),
  create: props => DefaultSuite(CreateGuesser, props),
  list: props => <ListGuesser {...props}>
    <FieldGuesser source={"name"}/>
    <FieldGuesser source={"slug"}/>
  </ListGuesser>
}
