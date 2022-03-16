<template>
    <div class="c-sidebar c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-md-down-none">
            <a :href="Helper.urlFormat('/')">
                <img :src="Helper.urlFormat('/images/desktop/global/footer-logo.png')" width="100"
                     class="c-sidebar-brand-full" alt="덴탈 브레인">
            </a>
        </div>

        <ul class="c-sidebar-nav ps ps--active-y">
            <li class="c-sidebar-nav-title">Resources</li>

            <!-- 회원 정보 메뉴 -->
            <li class="c-sidebar-nav-dropdown"
                :class="{ showClass: checkUrl('/admin/user') }">
                <a href="#" class="c-sidebar-nav-dropdown-toggle">회원관리</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <router-link to="/admin/user/user/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/user/user/1') }">
                            회원 정보
                        </a>
                    </router-link>
                    <router-link to="/admin/user/membership/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/user/membership') }">
                            유료 회원
                        </a>
                    </router-link>
                </ul>
            </li>

            <!-- 결제 정보 메뉴 -->
            <li class="c-sidebar-nav-item">
                <router-link to="/admin/payment/1" class="c-sidebar-nav-link"
                             :class="{ activeClass: checkUrl('/admin/payment') }">
                    결제정보
                </router-link>
            </li>

            <!-- 배너 관리 메뉴 -->
            <li class="c-sidebar-nav-dropdown"
                :class="{ showClass: checkUrl('/admin/lecture') }">
                <a href="#" class="c-sidebar-nav-dropdown-toggle">배너관리</a>

                <ul class="c-sidebar-nav-dropdown-items">
                    <router-link to="/admin/banner/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/banner') }">
                            배너관리 1
                        </a>
                    </router-link>
                    <router-link to="/admin/banner2/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/banner2') }">
                            배너관리 2
                        </a>
                    </router-link>
                    <router-link to="/admin/banner3/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/banner3') }">
                            배너관리 3
                        </a>
                    </router-link>
                </ul>
            </li>

            <!-- 강의 관리 메뉴 -->
            <li class="c-sidebar-nav-dropdown"
                :class="{ showClass: checkUrl('/admin/lecture') }">
                <a href="#" class="c-sidebar-nav-dropdown-toggle">강의관리</a>

                <ul class="c-sidebar-nav-dropdown-items">
                    <router-link to="/admin/lecture/online/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/lecture/online') }">
                            온라인 강의
                        </a>
                    </router-link>
                    <router-link to="/admin/lecture/offline/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/lecture/offline') }">
                            오프라인 강의
                        </a>
                    </router-link>
                    <router-link to="/admin/lecture/question/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/lecture/question') }">
                            질문내역
                        </a>
                    </router-link>
                </ul>
            </li>

            <!-- 커뮤니티 관리 메뉴 -->
            <li class="c-sidebar-nav-item">
                <router-link to="/admin/community/1" class="c-sidebar-nav-link"
                             :class="{ activeClass: checkUrl('/admin/community') }">
                    커뮤니티
                </router-link>
            </li>

            <!-- 고객센터 메뉴 -->
            <li class="c-sidebar-nav-dropdown"
                :class="{ showClass: checkUrl('/admin/customer') }">
                <a href="#" class="c-sidebar-nav-dropdown-toggle">고객센터</a>

                <ul class="c-sidebar-nav-dropdown-items">
                    <router-link to="/admin/customer/faq/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/customer/faq') }">
                            FAQ
                        </a>
                    </router-link>
                    <router-link to="/admin/customer/notice/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/customer/notice') }">
                            공지사항
                        </a>
                    </router-link>
                    <router-link to="/admin/customer/inquire/1" tag="li" class="c-sidebar-nav-item">
                        <a href="#" class="c-sidebar-nav-link"
                           :class="{ activeClass: checkUrl('/admin/customer/inquire') }">
                            문의내역
                        </a>
                    </router-link>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'AdminNavigation',
        data () {
            return {
                showClass: 'c-show',
                activeClass: 'c-active'
            }
        },
        computed: {
            currentPage() {
                return this.$route.path;
            }
        },
        methods: {
            checkUrl(url) {
                return this.currentPage.includes(url);
            }
        }
}
</script>
