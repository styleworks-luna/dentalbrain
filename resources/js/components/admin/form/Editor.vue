<template>
    <el-tiptap  height="400" :extensions="extensions" placeholder="Write something ..." v-model="contents" @onUpdate="handleSetEditor"/>
</template>

<script>
import Vue from 'vue';
import {
    Doc,
    Text,
    Paragraph,
    FontType,
    FontSize,
    Bold,
    Underline,
    Italic,
    Strike,
    TextColor,
    TextHighlight,
    TextAlign,
    BulletList,
    OrderedList,
    ListItem,
    TodoItem,
    TodoList,
    Indent,
    HardBreak,
    LineHeight,
    Blockquote,
    Link,
    Image,
    Table,
    TableHeader,
    TableCell,
    TableRow,
    CodeView,
    HorizontalRule,
    History,
} from "element-tiptap";

import codemirror from "codemirror";
import "codemirror/lib/codemirror.css"; // import base style
import "codemirror/mode/xml/xml.js"; // language
import "codemirror/addon/selection/active-line.js"; // require active-line.js
import "codemirror/addon/edit/closetag.js"; // autoCloseTags
import ElementUI from 'element-ui';
import { ElementTiptapPlugin } from 'element-tiptap';
import 'element-ui/lib/theme-chalk/index.css';
import 'element-tiptap/lib/index.css';

Vue.use(ElementUI);
Vue.use(ElementTiptapPlugin, {
    lang: "ko",
    // spellcheck: false,
});


// editor file upload
async function uploadImage(image) {
    let uploadForm = new FormData();
    uploadForm.append('image', image);
    const headers = {
        'Content-type': 'multipart/form-data'
    };
    const response = await axios.post('/api/admin/lecture/upload', uploadForm, {headers: headers} );
    return response.data.file.url
}

export default {
    name: "Editor",
    props: {
      'content' : [String]
    },
    data: () => ({
        extensions: [
            new Doc(),
            new Text(),
            new Paragraph(),
            new FontType({
                fontTypes: {
                    'Arial': 'Arial',
                    'Arial Black': 'Arial Black',
                    'Georgia': 'Georgia',
                    'Impact': 'Impact',
                    'Tahoma': 'Tahoma',
                    'Times New Roman': 'Times New Roman',
                    'Verdana': 'Verdana',
                    'Courier New': 'Courier New',
                    'Lucida Console': 'Lucida Console',
                    'Monaco': 'Monaco',
                    'monospace': 'monospace',
                }
            }),
            new FontSize({
                fontSizes: ['8', '10', '12', '14', '16', '18', '20', '24', '30', '36', '48', '60']
            }),
            new Bold({ bubble: true }),
            new Underline({ bubble: true }),
            new Italic({ bubble: true }),
            new Strike({ bubble: true }),
            new TextColor({
                colors: [
                    '#f44336',
                    '#e91e63',
                    '#9c27b0',
                    '#673ab7',
                    '#3f51b5',
                    '#2196f3',
                    '#03a9f4',
                    '#00bcd4',
                    '#009688',
                    '#4caf50',
                    '#8bc34a',
                    '#cddc39',
                    '#ffeb3b',
                    '#ffc107',
                    '#ff9800',
                    '#ff5722',
                    '#000000',]
            }),
            new TextHighlight({
                colors: [
                    '#f44336',
                    '#e91e63',
                    '#9c27b0',
                    '#673ab7',
                    '#3f51b5',
                    '#2196f3',
                    '#03a9f4',
                    '#00bcd4',
                    '#009688',
                    '#4caf50',
                    '#8bc34a',
                    '#cddc39',
                    '#ffeb3b',
                    '#ffc107',
                    '#ff9800',
                    '#ff5722',
                    '#000000',
                ]
            }),
            new TextAlign(),
            new ListItem(),
            new BulletList({ bubble: true }),
            new OrderedList({ bubble: true }),
            new TodoItem(),
            new TodoList(),
            new HardBreak(),
            new Indent(),
            new HorizontalRule({ bubble: true }),
            new LineHeight({
                lineHeights: ['50%', '80%', '100%', '120%', '150%', '180%', '200%']
            }),
            new Blockquote(),
            new Link({ bubble: true }),
            new Image({
                uploadRequest: uploadImage
            }),
            new Table({
                resizable: true
            }),
            new TableHeader(),
            new TableRow(),
            new TableCell(),
            new CodeView({
                codemirror,
                codemirrorOptions: {
                    styleActiveLine: true,
                    autoCloseTags: true
                }
            }),
            new History(),
        ],
        contents: '',
    }),
    mounted() {
        this.contents = this.content;
    },
    watch: {
        content() {
            this.contents = this.content;
        }
    },
    methods: {
        handleSetEditor() {
            this.$emit('setEditor', this.contents);
        },
    }
};
</script>
