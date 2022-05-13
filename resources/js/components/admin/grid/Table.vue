<template>
    <table class="table table-responsive-sm table-bordered text-center">
        <colgroup>
            <col v-for="col in tableCol"
                 :style="{ width: col.width }">
        </colgroup>
        <thead>
            <tr>
                <th v-for="col in tableCol"
                    :key="col.name">
                    {{ col.text }}

                    <slot v-if="col.isSort" :name="col.name"></slot>
                </th>
            </tr>
        </thead>

        <tbody>
            <template v-if="data.length > 0">
                <tr v-for="(row, index) in data"
                    :key="row.num ? row.num : row.id">
                    <slot name="list" :row="row" :idx="index"></slot>
                </tr>
            </template>

            <tr class="empty-list" v-else>
                <td :colspan="tableCol.length">데이터가 없습니다.</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: 'Table',
        props: {
            tableCol: Array,
            data: Array
        }
    }
</script>
