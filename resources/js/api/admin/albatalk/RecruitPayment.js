import Send from '@/utils/Send.js';

export default {
    getData() {
        return Send({
            url: '/api/admin/recruit-price',
            method: 'get',
        });
    },
    updatePrice(price) {
        return Send({
            url: `/api/admin/recruit-price/normal`,
            method: 'post',
            data: {
                'price': price
            }
        });
    },
    updateMembershipPrice(price) {
        return Send({
            url: `/api/admin/recruit-price/membership`,
            method: 'post',
            data: {
                'price': price
            }
        });
    },
}
