<template>
    <div class="content-title">
        <h2 v-if="!like && !certificate">신청한 강의</h2>
        <h2 v-else-if="certificate">증명서</h2>
        <h2 v-else>찜 내역</h2>
        <template v-if="!mobile && !certificate">
            <ul>
                <li :class="{'active': is_active == 1}" @click.prevent="handleSetOrder('newest',1)">
                    <a href="">최신순</a>
                </li>
                <li :class="{'active': is_active == 2}" @click.prevent="handleSetOrder('online',2)">
                    <a href="">온라인</a>
                </li>
                <li :class="{'active': is_active == 3}" @click.prevent="handleSetOrder('offline',3)">
                    <a href="">오프라인</a>
                </li>
                <li :class="{'active': is_active == 4}" @click.prevent="handleSetOrder('certificate',4)">
                    <a href="">수료/자격증</a>
                </li>
            </ul>
        </template>
        <template v-else-if="mobile">
            <div class="lecture-menu">
            <select name="mypage-menu" id="mypage-menu" class="mypage-menu-select" v-model="order" @change="handleSetOrderSelect" @click="handleClass" @blur="handleClassOut">
                <option value="newest" selected>최신순</option>
                <option value="online">온라인</option>
                <option value="offline">오프라인</option>
                <option value="certificate">수료/자격증</option>
            </select>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        'mobile': Boolean,
        'like': Boolean,
        'certificate': Boolean,
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
              {
                  id: 'certificate',
                  name: '수료/자격증'
              },
          ],
          order: 'newest',
      }
    },
    methods: {
        handleSetOrder(order,active) {
            this.is_active = active;
            this.$emit('setOrder',order);
        },
        handleSetOrderSelect() {
            this.$emit('setOrder',this.order)
        },
        handleClass() {
            document.getElementById('mypage-menu').classList.toggle('select-focus-in');
        },
        handleClassOut() {
            document.getElementById('mypage-menu').classList.remove('select-focus-in');
        }
    }
}
</script>
