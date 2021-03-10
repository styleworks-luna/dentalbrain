<template>
    <textarea id="editor-area"></textarea>
</template>

<script>
import 'font-awesome/css/font-awesome.min.css';

import 'froala-editor/css/froala_editor.pkgd.min.css';
import 'froala-editor/css/froala_style.min.css';

import 'froala-editor/js/froala_editor.pkgd.min.js';

export default {
    name: "Editor",
    props: {
        content: String,
    },
    data() {
        return {
            contents: '',
        }
    },
    watch: {
        content(newValue, oldValue) {
            this.contents = this.content;
        }
    },
    mounted() {
        this.initEditor();
    },
    methods: {
        initEditor() {
            $('#editor-area').froalaEditor({
                key: '7TYPASIBGMWG1YLMP==',
                height: 450,
                requestHeaders: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                imageUploadParam: 'image',
                imageUploadURL: '/api/admin/lecture/upload',
                fileUploadURL: '/api/admin/lecture/upload',
            }).on('froalaEditor.input', (e, editor) => {
                const data = editor.html.get();
                this.onEditorInput(data);
            })
        },
        onEditorInput(data) {
            this.$emit('setEditor', data);
        }
    }
};
</script>

<style scoped>

</style>
