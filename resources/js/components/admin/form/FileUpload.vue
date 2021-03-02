<template>
    <div class="input-file-wrap overflow-hidden">
        <input type="file" class="d-none" :id="inputId"
               @change="fileUpload"
               accept=".Key, .PDF, .Doc, .PPT, .Pages, .pptx, .docx, .xlsx,
                       .xls, .hwp, .JPG, .JPEG, .PNG, .GIF, .zip, .alz, .rar">
        <label class="btn btn-info float-left w-30"
               :for="inputId">
            파일선택
        </label>
        <p class="input-file form-control float-left">
            <span v-if="initFile">{{ initFile.name }}</span>
        </p>
    </div>
</template>

<script>
// api
import FileUpload from '@/api/admin/common/Upload.js';

export default {
    name: 'FileUpload',
    props:['inputId', 'initFile', 'index'],
    methods: {
        fileUpload(e) {
            let uploadForm = new FormData();
            uploadForm.append('file', e.target.files[0]);
            FileUpload.fileUpload(uploadForm).then(res => {
                this.$emit('setFile', res.data.file, this.index);
            }).catch(function (err) {
                alert('오류');
            });
        }
    }
}
</script>
