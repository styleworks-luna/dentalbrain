<template>
    <div class="c-sidebar c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-md-down-none">
            <a :href="Helper.urlFormat('/')">
                <img :src="Helper.urlFormat('/images/global/header_bics_logo.png')" width="150"
                     class="c-sidebar-brand-full" alt="BICS 2019">
            </a>
        </div>

        <ul class="c-sidebar-nav ps ps--active-y">
            <li class="c-sidebar-nav-item">
                <router-link to="/admin/dashboard" class="c-sidebar-nav-link"
                             :class="currentPage == '/admin/dashboard' ? activeClass : ''">
                    Dashboard
                </router-link>
            </li>

            <li class="c-sidebar-nav-title">Resources</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'AdminNavigation',
        data () {
            return {
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
