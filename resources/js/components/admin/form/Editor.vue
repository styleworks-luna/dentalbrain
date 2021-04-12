
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
            $.FroalaEditor.DefineIconTemplate('line_height_icon', '<i class="fa fa-text-height"></i>');
            $.FroalaEditor.DefineIcon('lineHeight',  {NAME: 'LineHeight', template: 'line_height_icon'});

            $.FroalaEditor.DefineIconTemplate('font_size_icon', '<i class="fa fa-text-width"></i>');
            $.FroalaEditor.DefineIcon('fontSize', {NAME: 'fontSize', template: 'font_size_icon'});

            $.FroalaEditor.RegisterCommand('lineHeight', {
                title: 'Line Height',
                type: 'dropdown',
                icon: 'lineHeight',
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
                    let selectionText  = window.getSelection();
                    selectionText.anchorNode.parentNode.style.lineHeight = val;
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
                fileUploadParam: 'file',
                toolbarButtons: [
                    'fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',
                    '|',
                    'fontFamily', 'fontSize','lineHeight', 'color', 'inlineClass', 'inlineStyle', 'paragraphStyle',
                    '|',
                    'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote',
                    '-',
                    'insertLink','insertFile', 'insertImage', 'insertVideo','insertTable',
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
