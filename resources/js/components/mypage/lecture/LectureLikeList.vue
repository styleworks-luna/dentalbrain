<template>
    <div class="mypage-like">
        <div class="mypage-content">
            <ul>
                <li v-for="lecture in lectures" :key="lecture.id">
                    <div class="content-information-wrap">
                        <figure class="content-image">
                            <a :href="'/lectures/' + lecture.id">
                                <img :src="lecture.thumbnail.url" alt="강의사진">
                            </a>
                        </figure>
                        <div class="content-information">
                            <div class="lecture-sort">
                                <span class="online" v-if="lecture.is_online">온라인</span>
                                <span class="offline" v-else>오프라인</span>
                                <p class="lecture-subject">
                                    <template v-if="lecture.minor_category_name">
                                        {{ lecture.major_category_name }} &middot;
                                        {{ lecture.minor_category_name }}
                                    </template>
                                    <template v-else>
                                        {{ lecture.major_category_name }}
                                    </template>
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
                                            <template v-if="!lecture.is_repeated">
                                                {{
                                                lecture.is_free == 1 ? '무료' :
                                                Helper.numberWithCommas(lecture.price) + '원'
                                                }}
                                            </template>
                                            <template v-else>
                                                {{
                                                '재수강 할인가: ' + Helper.numberWithCommas(lecture.repeat_price) + '원'
                                                }}
                                            </template>
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
                            <a :href="'/lectures/' + lecture.id" class="btn-lecture">강의 바로가기</a>
                        </div>
                </li>
                <li class="content-none" v-if="lectures.length == 0">찜한 강의가 없습니다.</li>
            </ul>

        </div>
    </div>
</template>

<script>

export default {
    name: 'MypageLectureLikeList',
    props: {
        'listData': Array,
        'mobile': Boolean,
    },
    computed: {},
    data() {
        return {
            lectures: [],
        }
    },
    watch: {
        listData() {
            this.lectures = this.listData;
        }
    },
}
</script>
