<template>
    <layout title="sns 보내기">
        <template v-slot:button>

        </template>

        <template v-slot:search>

        </template>

        <template v-slot:body>

        </template>
    </layout>
</template>

<script>
// component
import Table from '@/components/admin/grid/Table.vue';

export default {
    name: 'AdminEmail',
    components: {
        'table-grid': Table,
    },
    data() {
        return {
        }
    },
    created() {
    },
    mounted() {
    },
    methods: {}
}
</script>
