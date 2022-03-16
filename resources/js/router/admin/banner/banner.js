import Banner from '@/views/admin/banner/Banner.vue';
import Banner2 from '@/views/admin/banner/Banner2.vue';
import Banner3 from '@/views/admin/banner/Banner3.vue';
import BannerEdit from '@/views/admin/banner/BannerEdit.vue';
import BannerCreate from '@/views/admin/banner/BannerCreate.vue';

const routes = [
    {
        path: '/admin/banner/create',
        name: 'AdminBannerCreate',
        component: BannerCreate
    },
    {
        path: '/admin/banner/:page',
        name: 'AdminBanner',
        component: Banner
    },
    {
        path: '/admin/banner2/:page',
        name: 'AdminBanner',
        component: Banner2
    },
    {
        path: '/admin/banner3/:page',
        name: 'AdminBanner',
        component: Banner3
    },
    {
        path: '/admin/banner/:id/:page',
        name: 'AdminBannerEdit',
        component: BannerEdit
    },

];

export default routes;
