<template>
    <ckeditor :content="content" :config="editorConfig" @input="onEditorInput"></ckeditor>
</template>

<script>
import Vue from 'vue';
import CKEditor from 'ckeditor4-vue';

Vue.use(CKEditor);

export default {
    name: "Editor",
    props: {
        content: String,
    },
    data() {
        return {
            editorConfig: {
                extraPlugins: 'font, colorbutton, emoji, tableresize',
            },
        }
    },
    methods: {
        onEditorInput(e) {
            this.$emit('setEditor', e)
        }
    }

};
</script>
