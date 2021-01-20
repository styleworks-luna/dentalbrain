import Banner from '@/views/admin/banner/Banner.vue';
import BannerEdit from '@/views/admin/banner/BannerEdit.vue';

const routes = [
    {
        path: '/admin/banner',
        name: 'AdminBanner',
        component: Banner
    },
    {
        path: '/admin/banner/:id',
        name: 'AdminBannerEdit',
        component: BannerEdit
    },
];

export default routes;
