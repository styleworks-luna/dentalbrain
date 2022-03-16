import Banner from '@/views/admin/banner/Banner.vue';
import Banner2 from '@/views/admin/banner/Banner2.vue';
import Banner3 from '@/views/admin/banner/Banner3.vue';
import BannerEdit from '@/views/admin/banner/BannerEdit.vue';
import Banner2Edit from '@/views/admin/banner/Banner2Edit.vue';
import Banner3Edit from '@/views/admin/banner/Banner3Edit.vue';
import BannerCreate from '@/views/admin/banner/BannerCreate.vue';
import Banner2Create from '@/views/admin/banner/Banner2Create.vue';
import Banner3Create from '@/views/admin/banner/Banner3Create.vue';

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
        path: '/admin/banner2/create',
        name: 'AdminBanner2Create',
        component: Banner2Create
    },
    {
        path: '/admin/banner2/:page',
        name: 'AdminBanner2',
        component: Banner2
    },
    {
        path: '/admin/banner3/create',
        name: 'AdminBanner3Create',
        component: Banner3Create
    },
    {
        path: '/admin/banner3/:page',
        name: 'AdminBanner3',
        component: Banner3
    },
    {
        path: '/admin/banner/:id/:page',
        name: 'AdminBannerEdit',
        component: BannerEdit
    },
    {
        path: '/admin/banner2/:id/:page',
        name: 'AdminBanner2Edit',
        component: Banner2Edit
    },
    {
        path: '/admin/banner3/:id/:page',
        name: 'AdminBanner3Edit',
        component: Banner3Edit
    },

];

export default routes;
