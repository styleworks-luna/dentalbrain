<template>
    <div class="input-file-wrap overflow-hidden">
        <input type="file" class="d-none" :id="inputId"
               @change="fileUpload">
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
import ImageUpload from '@/api/admin/common/Upload.js';

export default {
    name: 'ImageUpload',
    props:['inputId', 'initFile'],
    methods: {
        imageUpload(e) {
            let uploadForm = new FormData();
            uploadForm.append('image', e.target.files[0]);
            ImageUpload.imageUpload(uploadForm).then(res => {
                this.$emit('setImage', res.data.file);
            }).catch(function (err) {
                alert('오류');
            });
        }
    }
}
</script>
