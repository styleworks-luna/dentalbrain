<template>
    <div class="c-app">
        <admin-navigation></admin-navigation>

        <div class="c-wrapper">
            <admin-header></admin-header>

            <div class="c-body">
                <main class="content c-main">
                    <div class="container-fluid">
                        <router-view />
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
    import AdminHeader from '@/components/admin/Header.vue';
    import AdminNavigation from '@/components/admin/Navigation.vue';

    export default {
        name: 'Admin',
        components: {
            'admin-header': AdminHeader,
            'admin-navigation': AdminNavigation
        }
    }
</script>

<style lang="scss">
    @import "~@coreui/coreui/scss/coreui";
    @import '~@coreui/icons/css/free.min.css';
    @import "@sass/admin.sass";
</style>
