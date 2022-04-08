/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
    config.toolbar = [
        ['SpecialChar', 'Smiley'],
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
        ['Blockquote', 'NumberedList', 'BulletedList'],
        ['Link', 'Unlink'],
        ['Source'],
        ['Undo', 'Redo'],
        '/',
        ['Font', 'FontSize'],
        ['BGColor', 'TextColor'],
        ['Bold', 'Italic', 'Strike', 'Superscript', 'Subscript', 'Underline', 'RemoveFormat'],
        ['BidiLtr', 'BidiRtl'],
    ];
    config.extraPlugins = ['autolink'];
    config.autoUpdateElement= true;
};
