<template>
    <textarea name="editor" id="editor-area" :content="content" @input="onEditorInput"></textarea>
</template>

<script>
import 'font-awesome/css/font-awesome.min.css';

import 'froala-editor/css/froala_editor.pkgd.min.css';
import 'froala-editor/css/froala_style.min.css';

import 'froala-editor/js/froala_editor.pkgd.min.js';

function editor() {
    $('#editor-area').froalaEditor({
        key: '7TYPASIBGMWG1YLMP==',
        height: 450,
        requestHeaders: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        imageUploadParam: 'image',
        imageUploadURL: '/api/admin/lecture/upload',
        fileUploadURL: '/api/admin/lecture/upload',
    }).on('froalaEditor.eventName', function (e, editor, param1, param2) {
        // Callback code here.
    })
}

export default {
    name: "Editor",
    props: {
        content: String,
    },
    data() {
        return {
        }
    },
    mounted() {
        editor();
    },
    methods: {
        onEditorInput() {
            this.$emit('setEditor');
        }
    }
};
</script>

<style scoped>

</style>
