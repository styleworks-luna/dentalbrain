<template>
    <ckeditor :editor="editor" @ready="onReady" :content="content" :config="editorConfig" @input="onEditorInput"></ckeditor>
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue2';
import DecoupledEditor from '@ckeditor/ckeditor5-build-decoupled-document';

console.dir(DecoupledEditor.builtinPlugins.map( plugin => plugin.pluginName ));

export default {
    name: "Editor",
    props: {
        content: String,
    },
    components: { ckeditor: CKEditor.component },
    data() {
        return {
            editor: DecoupledEditor,
            editorConfig: {
                simpleUpload: {
                    uploadUrl: '/api/admin/lecture/upload' ,// 내가 지정한 업로드 url
                    withCredentials: true,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            },
        }
    },
    methods: {
        onEditorInput(e) {
            this.$emit('setEditor', e)
        },
        onReady(editor) {
            // Insert the toolbar before the editable area.
            editor.ui.getEditableElement().parentElement.insertBefore(
                editor.ui.view.toolbar.element,
                editor.ui.getEditableElement()
            );
        },
    }
};
</script>

<style scoped>
.ck-editor__editable_inline {
    height: 450px;
    overflow-y: scroll;
}

.ck.ck-content.ck-editor__editable.ck-rounded-corners.ck-editor__editable_inline.ck-blurred {
    border: 1px solid #000;
}
</style>
