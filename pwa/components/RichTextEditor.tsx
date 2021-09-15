import dynamic from 'next/dynamic';
import {Props} from "react";

export const RichTextEditorWrapper = dynamic(
  import('ra-input-rich-text'),
  {
    ssr: false,
    loading: () => <div>Loading...</div>,
  }
);


export const ConfiguredRichText = props => {
  return (
    <RichTextEditorWrapper {...props} options={{
      modules: {
        history: {
          delay: 2000,
          maxStack: 500,
          userOnly: true
        },
        toolbar: [
          ['bold', 'italic', 'underline', 'strike'],
          ['blockquote', 'code-block'],
          [{'header': 1}, {'header': 2}],
          [{'list': 'ordered'}, {'list': 'bullet'}],
          [{'script': 'sub'}, {'script': 'super'}],
          [{'indent': '-1'}, {'indent': '+1'}],
          [{'direction': 'rtl'}],
          [{'size': ['small', false, 'large', 'huge']}],
          [{'header': [1, 2, 3, 4, 5, 6, false]}],
          [{'color': []}, {'background': []}],
          [{'font': []}],
          [{'align': []}],
          ['clean']
        ]
      }
    }}/>
  );
}
