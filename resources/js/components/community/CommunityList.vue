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
                <div class="community-summary">
                    <span class="sort">{{ article.category_name }}</span>
                    <a href="" class="title" @click.prevent="showDetail(index)">{{ article.title }}</a>
                    <span class="writer">{{ article.writer }}</span>
                    <span class="date">{{ Helper.dateFormatYDM(article.date) }}</span>
                    <div class="like"><span class="icon-like"></span><span>15800</span></div>
                    <span class="view">{{ article.views }}</span>
                    <span class="btn-arrow-down"></span>
                </div>
                <div :id="`detail${index}`" class="community-detail">
                    <div class="community-detail-title">
                        <h2>제목</h2>
                        <p>{{ article.title }}</p>
                    </div>
                    <div class="community-detail-content">
                        <h2>내용</h2>
                        <p v-html="article.content"></p>
                    </div>
                    <div class="btn-wrap">
                        <button type="button" class="btn-like">15800</button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'CommunityList',
    props: {
        'list': [Object,Array]
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
        showDetail(id) {
            console.log(id);
            var show = document.getElementById(`detail${id}`);
            show.style.display = 'block';
            console.log(this.list);
        }
    }
}

</script>
