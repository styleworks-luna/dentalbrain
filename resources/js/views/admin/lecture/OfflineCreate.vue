<template>
    <layout title="오프라인 강의 등록" id="lecture">
        <template v-slot:body>
                <additional-information :data="surveys"></additional-information>
        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info" @click="create">등록</button>
                <router-link to="/admin/lecture/offline"
                             class="btn btn-dark">취소
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import AdditionalInformation from '@/components/common/AdditionalInformation.vue'

export default {
    name: 'AdminOnlineCreate',
    components: {
        'single-group': SingleGroup,
        'additional-information': AdditionalInformation,
    },
    data() {
        return {
            surveys: []
        }
    },
    mounted() {
        // const instance = this;
        // setTimeout(function() {
        //     instance.surveys = [
        //
        //         {
        //             type: 'singleChoice',
        //             question: '',
        //             is_required: 0,
        //             items: [

        //              {
        //                  id: 1
        //              }
        //             ],
        //         },
        //         {
        //             type: 'multipleChoice',
        //             question: '',
        //             is_required: 0,
        //             items: [],
        //         },
        //         {
        //             type: 'shortAnswer',
        //             question: '',
        //             is_required: 0,
        //         },
        //         {
        //             type: 'longAnswer',
        //             question: '',
        //             is_required: 0,
        //         },
        //         {
        //             type: 'address',
        //             question: '',
        //             is_required: 0,
        //         },
        //         {
        //             type: 'file',
        //             question: '',
        //             is_required: 0,
        //         }
        //
        //     ]
        // }, 100)
    },
    methods: {
        create() {
            console.log(this.$data);
        }
    }

}

</script>
