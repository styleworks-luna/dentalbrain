<template>
    <el-tiptap  height="400"
                placeholder="Write something ..."
                :lang="'en'"
                :content="content"
                :extensions="extensions"
                @onUpdate="handleSetEditor"/>
</template>

<script>
import Vue from 'vue';

import { ElementTiptap } from 'element-tiptap';
import 'element-ui/lib/theme-chalk/index.css';
import 'element-tiptap/lib/index.css';
import {
    Doc,
    Text,
    Paragraph,
    FontSize,
    Bold,
    Underline,
    Italic,
    Strike,
    TextColor,
    TextAlign,
    BulletList,
    OrderedList,
    ListItem,
    TodoItem,
    TodoList,
    Indent,
    HardBreak,
    Blockquote,
    Link,
    Image,
    Table,
    TableHeader,
    TableCell,
    TableRow,
    CodeView,
    HorizontalRule
} from "element-tiptap";

import codemirror from "codemirror";
import "codemirror/lib/codemirror.css"; // import base style
import "codemirror/mode/xml/xml.js"; // language
import "codemirror/addon/selection/active-line.js"; // require active-line.js
import "codemirror/addon/edit/closetag.js"; // autoCloseTags

// editor file upload
let uploadImage = async (image) => {
    let uploadForm = new FormData();
    uploadForm.append('image', image);
    const headers = {
        'Content-type': 'multipart/form-data'
    };

    try {
        const response = await axios.post('/api/admin/lecture/upload', uploadForm, {headers: headers} );
        return response.data.file.url;
    } catch(e) {
        alert('오류');
        return e;
    }
}

export default {
    name: "Editor",
    props: {
      'content' : String
    },
    components: {
        'el-tiptap': ElementTiptap
    },
    data() {
        return {
            extensions: [
                new Doc(),
                new Text(),
                new Paragraph(),
                new FontSize({
                    fontSizes: ['8', '10', '12', '14', '16', '18', '20', '24', '30', '36', '48', '60']
                }),
                new Bold({ bubble: true }),
                new Underline({ bubble: true }),
                new Italic(),
                new Strike(),
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
                new TextAlign(),
                new ListItem(),
                new BulletList(),
                new OrderedList(),
                new HardBreak(),
                new Indent(),
                new HorizontalRule({ bubble: true }),
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
                })
            ]
        }
    },
    methods: {
        handleSetEditor(e) {
            console.log('handleSeteditor ---------');
            console.log(e);
            this.$emit('setEditor', e);
        },
    }
};
</script>
