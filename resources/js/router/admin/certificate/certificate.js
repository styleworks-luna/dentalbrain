import Information from '@/views/admin/certificate/Information.vue';
import History from '@/views/admin/certificate/History.vue';
import CertificateCreate from '@/views/admin/certificate/CertificateCreate.vue';
import CompletionCreate from '@/views/admin/certificate/CompletionCreate.vue';
import CertificateEdit from '@/views/admin/certificate/CertificateEdit.vue';
import CompletionEdit from '@/views/admin/certificate/CompletionEdit.vue';

const routes = [
    {
        path: '/admin/certificate/information',
        name: 'Information',
        component: Information
    },
    {
        path: '/admin/certificate/history',
        name: 'History',
        component: History
    },
    {
        path: '/admin/certificate/create/certificate',
        name: 'CertificateCreate',
        component: CertificateCreate
    },
    {
        path: '/admin/certificate/create/completion',
        name: 'CompletionCreate',
        component: CompletionCreate
    },
    {
        path: '/admin/certificate/certificate/:id',
        name: 'CertificateEdit',
        component: CertificateEdit
    },
    {
        path: '/admin/certificate/completion/:id',
        name: 'CompletionEdit',
        component: CompletionEdit
    },

];

export default routes;
