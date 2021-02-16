<template>
    <div class="content-title">
        <h2>신청한 강의</h2>
        <ul>
            <li :class="{'active': is_active == 1}" @click.prevent="handleSetOrder('newest',1)"><a href="">최신순</a></li>
            <li :class="{'active': is_active == 2}" @click.prevent="handleSetOrder('online',2)"><a href="">온라인</a></li>
            <li :class="{'active': is_active == 3}" @click.prevent="handleSetOrder('offline',3)"><a href="">오프라인</a></li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
      return {
          is_active: 1,
      }
    },
    methods: {
        handleSetOrder(order,active) {
            this.is_active = active;
            this.$emit('setOrder',order);
        },
    }
}
</script>
