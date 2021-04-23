<template>
    <div class="content-title">
        <h2>신청한 강의</h2>
        <template v-if="!mobile">
        <ul>
            <li :class="{'active': is_active == 1}" @click.prevent="handleSetOrder('newest',1)"><a href="">최신순</a></li>
            <li :class="{'active': is_active == 2}" @click.prevent="handleSetOrder('online',2)"><a href="">온라인</a></li>
            <li :class="{'active': is_active == 3}" @click.prevent="handleSetOrder('offline',3)"><a href="">오프라인</a></li>
        </ul>
        </template>
        <template v-else>
            <select name="mypage-menu" id="mypage-menu" class="mypage-menu-select" v-model="order" @change="handleSetOrderSelect">
                <option value="newest">최신순</option>
                <option value="online">온라인</option>
                <option value="offline">오프라인</option>
            </select>
        </template>
    </div>
</template>

<script>
export default {
    props: {
      'mobile': Boolean,
    },
    data() {
      return {
          is_active: 1,
          orderOptions:[
              {
                  id: 'newest',
                  name: '최신순'
              },
              {
                  id: 'online',
                  name: '온라인'
              },
              {
                  id: 'offline',
                  name: '오프라인'
              },
          ],
          order: '',
      }
    },
    methods: {
        handleSetOrder(order,active) {
            this.is_active = active;
            this.$emit('setOrder',order);
        },
        handleSetOrderSelect() {
            this.$emit('setOrder',this.order)
        }
    }
}
</script>
