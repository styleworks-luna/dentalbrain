<template>
    <div class="popup-container">
        <div class="layer" @click="controlPopup"></div>
        <article class="popup-wrap">
            <header class="popup-header border-bottom d-flex justify-content-between">
                <h2 class="popup-title">내용 수정</h2>
            </header>

            <section class="popup-content">
                <div class="d-flex justify-content-start mb-3">
                    <div class="pr-3">
                        <p>사진 변경</p>
                        <div style="text-align: left">285x380</div>
                    </div>
                    <div class="pl-3">
                    <thumbnail :id="'thumbnail'"
                               :file="thumbnail"
                               @setFile="handleSetThumbnail"></thumbnail>
                    </div>
                </div>
                <single-group name="이름"
                              :isRow="true"
                              :isRequired="true"
                              :size="8">
                    <template v-slot:content>
                        <input type="text" class="form-control"
                               v-model="name">
                    </template>
                </single-group>
                <single-group name="생년월일"
                              :isRow="true"
                              :isRequired="true"
                              :size="8">
                    <template v-slot:content>
                        <input type="text" class="form-control"
                               v-model="birth">
                    </template>
                </single-group>
                <single-group name="대학교"
                              :isRow="true"
                              :isRequired="true"
                              :size="8">
                    <template v-slot:content>
                        <input type="text" class="form-control"
                               v-model="universe">
                    </template>
                </single-group>
                <single-group name="학번"
                              :isRow="true"
                              :isRequired="true"
                              :size="8">
                    <template v-slot:content>
                        <input type="text" class="form-control"
                               v-model="st_num">
                    </template>
                </single-group>
                <single-group name="점수"
                              :isRow="true"
                              :isRequired="true"
                              :size="8">
                    <template v-slot:content>
                        <input type="text" class="form-control"
                               v-model="score">
                    </template>
                </single-group>
            </section>
            <footer class="popup-footer border-top pt-3 d-flex justify-content-center">
                <button class="btn btn-info mr-3">저장</button>
                <button class="btn btn-secondary" @click="controlPopup">취소</button>
            </footer>
        </article>
    </div>
</template>

<script>
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import Thumbnail from '@/components/admin/form/Thumbnail.vue';

export default {
    name: "LectureCertificatePopup",
    props: {
        id: Number,
    },
    components: {
        'single-group': SingleGroup,
        Thumbnail,
    },
    mounted() {
    },
    data() {
        return {
            name: '',
            birth: '',
            universe: '',
            st_num: '',
            score: '',
            thumbnail: {},
        }
    },
    methods: {
        handleSetThumbnail(file) {
            this.thumbnail = file;
        },
        controlPopup() {
            this.$emit('close', false);
        }
    }
}
</script>
