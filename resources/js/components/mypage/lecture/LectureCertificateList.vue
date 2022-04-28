<template>
    <div class="mypage-certificateList">
        <div class="mypage-content">
            <ul>
                <li v-for="lecture in lectures" :key="lecture.id">
                    <div class="content-information-wrap">
                        <figure class="content-image">
                            <a :href="'/lectures/' + lecture.id">
                                <img :src="lecture.thumbnail.url" alt="강의사진">
                                <div class="certificate-mark">수료/자격증</div>
                            </a>
                        </figure>
                        <div class="content-information">
                            <div class="lecture-sort">
                                <span class="lecture-type">{{ lecture.minor_category_name }}</span>

                                <p class="lecture-date" v-if="lecture.minor_category_name!='스토어'">
                                    <template v-if="lecture.is_online==true">수강기간 {{ lecture.term }}일</template>
                                </p>
                            </div>
                            <h3 class="lecture-title">
                                <a :href="'/lectures/' + lecture.id">{{ lecture.title }}</a>
                            </h3>
                            <table v-if="lecture.is_online">
                                <tr>
                                    <th>강의시간</th>
                                    <td><p class="lecture-length">{{ lecture.running_time }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>결제금액</th>
                                    <td>
                                        <p class="lecture-pay">
                                            {{
                                                lecture.is_free == 1 ? '무료' :
                                                    Helper.numberWithCommas(lecture.price) + '원'
                                            }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table v-else>
                                <tr>
                                    <th>강의일시</th>
                                    <td>
                                        <p class="lecture-length">
                                            {{ lecture.place.korean_time }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>강의장소</th>
                                    <td><p class="lecture-length lecture-place">{{
                                            lecture.place.full_address
                                        }}</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="btn-zone">
                        <a class="btn-lecture">수료증 보기</a>
                        <a class="btn-lecture"><em>자격증 보기</em></a>
                    </div>
                </li>
                <li class="content-none" v-if="lectures.length == 0">찜한 강의가 없습니다.</li>
            </ul>

        </div>
    </div>
</template>

<script>

export default {
    name: 'MypageLectureCertificateList',
    props: {
        'listData': Array,
        'mobile': Boolean,
    },
    computed: {},
    data() {
        return {
            lectures: [{"id":44,"description":"test","major_category_id":1,"minor_category_id":4,"title":"test","price":0,"running_time":null,"thumbnail_id":126,"is_online":false,"is_free":1,"term":7,"major_category_name":"경영","minor_category_name":"치주","user_like_cnt":1,"auth_like":true,"thumbnail":{"id":126,"url":"/storage/program/44/thumbnail/1.png","name":"1.png"},"place":{"id":5,"program_id":44,"address":"서울특별시 영등포구 여의동로 330 한강사업본부 여의도안내센터","address_detail":"test","started_at":"2022-04-14 02:02:00","ended_at":"2022-04-15 02:02:00","korean_time":"2022년 04월 14일 (목) 02:02 ~ 2022년 04월 15일 (금) 02:02","full_address":"서울특별시 영등포구 여의동로 330 한강사업본부 여의도안내센터 test"},"pivot":{"user_id":1,"program_id":44},"major_category":{"id":1,"name":"경영"},"minor_category":{"id":4,"name":"치주"}},
                {"id":40,"description":"testtest","major_category_id":7,"minor_category_id":20,"title":"testtesttest","price":0,"running_time":"testtesttest","thumbnail_id":115,"is_online":true,"is_free":1,"term":11,"major_category_name":"스토어","minor_category_name":"스토어","user_like_cnt":1,"auth_like":true,"thumbnail":{"id":115,"url":"/storage/program/40/thumbnail/123.jpg","name":"123.jpg"},"place":null,"pivot":{"user_id":1,"program_id":40},"major_category":{"id":7,"name":"스토어"},"minor_category":{"id":20,"name":"스토어"}}
            ]
        }
    },
    // watch: {
    //     listData() {
    //         this.lectures = this.listData;
    //     }
    // },
}
</script>
