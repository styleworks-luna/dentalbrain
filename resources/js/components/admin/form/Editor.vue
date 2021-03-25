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
            if (newValue != null && oldValue == '') {
                $('#editor-area').froalaEditor('html.set', newValue);
            }
            this.contents = this.content;
        }
    },
    mounted() {
        this.initEditor();
    },
    methods: {
        initEditor() {
            $.FroalaEditor.DefineIcon('my_dropdown', {NAME: 'cog'});

            $.FroalaEditor.RegisterCommand('my_dropdown', {
                title: 'Advanced options',
                type: 'dropdown',
                focus: false,
                undo: false,
                refreshAfterCallback: true,
                options: {
                    '1': '1',
                    '1.2': '1.2',
                    '1.4': '1.4',
                    '1.6': '1.6',
                    '1.8': '1.8',
                    '2': '2',
                },
                callback: function (cmd, val) {
                },
                // Callback on refresh.
                refresh: function ($btn) {
                },
                // Callback on dropdown show.
                refreshOnShow: function ($btn, $dropdown) {
                }
            });

            $('#editor-area').froalaEditor({
                key: env.FROALA_LICENSE_KEY,
                height: 450,
                requestHeaders: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                imageUploadParam: 'image',
                imageUploadURL: '/api/admin/lecture/upload',
                fileUploadURL: '/api/admin/lecture/upload',
                toolbarButtons: [
                    'fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'my_dropdown',
                    '|',
                    'fontFamily', 'fontSize', 'color', 'inlineClass', 'inlineStyle', 'paragraphStyle',
                    '|',
                    'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote',
                    '-',
                    'insertLink', 'insertImage', 'insertTable',
                    '|',
                    'emoticons', 'fontAwesome', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting',
                    '|',
                    'print', 'getPDF', 'spellChecker', 'help', 'html',
                    '|',
                    'undo', 'redo'
                ]
            }).on('froalaEditor.contentChanged', (e, editor) => {
                const data = editor.html.get();
                this.onEditorInput(data);
            })
        },
        onEditorInput(data) {
            this.$emit('setEditor', data);
        },
    }
};
</script>

<style scoped>

</style>
