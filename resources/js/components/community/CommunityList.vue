<template>
    <div class="community-list-wrap">
        <ul class="community-lists">
            <li class="community-list-title">
                <span class="sort">분류</span>
                <span class="title">제목</span>
                <span class="writer">글쓴이</span>
                <span class="date">등록일</span>
                <span class="like">좋아요</span>
                <span class="view">조회수</span>
            </li>
            <li class="community-list-content" v-for="(article,index) in articles" :key="article.id">
                <div class="community-summary" @click.prevent="showDetail(article.id,index)">
                    <span class="sort">{{ article.category_name }}</span>
                    <a class="title">{{ article.title }}</a>
                    <span class="writer">{{ article.writer }}</span>
                    <span class="date">{{ Helper.dateFormatYDMByComma(article.date) }}</span>
                    <div class="view-wrap">
                    <div class="like">
                        <div class="like-wrap">
                            <span class="like-icon"></span><span :id="`like-count${index}`" class="like-count">{{ article.likes_count }}</span>
                        </div>
                    </div>
                    <span class="view"><span class="view-title">조회</span> {{ article.views }}</span>
                    </div>
                    <span :id="`arrow${index}`" class="btn-arrow-down"></span>
                </div>
                <div :id="`detail${index}`" class="community-detail hidden">
                    <div class="community-detail-title">
                        <p class="head">제목</p>
                        <p class="content">{{ article.title }}</p>
                    </div>
                    <div class="community-detail-content">
                        <p class="head">내용</p>
                        <div class="fr-element fr-view">
                            <p class="content" v-html="article.content"></p>
                        </div>
                    </div>
                    <div class="btn-wrap">
                        <button type="button" :id="`like${index}`" class="btn-like"
                                :class="article.liked ? 'active' : ''" @click.prevent="likeIt(article.id,index)">
                            <span class="like-icon"></span> <span class="like-count">{{ article.likes_count }}</span>
                        </button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
// api
import Community from '@/api/community/Community.js'

export default {
    name: 'CommunityList',
    props: {
        'list': [Object, Array],
    },
    data() {
        return {
            articles: [],
        }
    },
    watch: {
        list() {
            this.articles = this.list;
        }
    },
    methods: {
        showDetail(id, index) {
            var show = document.getElementById(`detail${index}`);
            var arrow = document.getElementById(`arrow${index}`);
            show.classList.toggle("hidden");
            arrow.classList.toggle('up');

            if (!show.classList.contains('hidden')) {
                Community.getView(id)
            }
        },
        likeIt(id, index) {
            var likeCountElement = document.getElementById(`like-count${index}`);
            var likeElement = document.getElementById(`like${index}`);
            var likeElementCnt = likeElement.lastChild;

            likeElement.classList.toggle("active");

            var like = '';

            if (likeElement.classList.contains("active")) {
                like = 'true';
            } else {
                like = 'false';
            }

            Community.postLike(id, {'like': like}).then(res => {
                likeCountElement.innerText = res.data.cnt;
                likeElementCnt.innerText = res.data.cnt;
            })
        }
    }
}
</script>
