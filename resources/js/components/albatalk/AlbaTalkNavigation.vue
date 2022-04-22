<template>
    <div class="albatalk-menu" id="albatalk-menu">
        <template v-if="mobile">
            <div class="albatalk-menu-list-wrap">
                <div class="albatalk-middle">
                    <div class="menu-title">
                        <p class="label">근무지역</p>
                        <span class="btn-close-menu" @click.prevent="exit()"></span>
                    </div>
                    <div class="m-row">
                        <div class="menu-content">
                            <p>근무지역을 선택해주세요.</p>
                            <ul class="albatalk-menu-list">
                                <li v-for="menuList in menuLists" :key="menuList.name">
                                    <a :id="`menu_list_${menuList.name}`" class="menu-list" :data-name="menuList.text"
                                       @click="mobileMenuEvent($event, menuList.text)">{{ menuList.text }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-else-if="!mobile && !show">
            <div class="albatalk-menu-list-wrap">
                <p class="label">근무지역</p>
                <ul class="albatalk-menu-list">
                    <li v-for="menuList in menuLists" :key="menuList.name">
                        <div class="checkbox-wrap">
                            <input type="checkbox" :id="'menu_list_' + menuList.name" name="menu_list"
                                   :value="menuList.text" @change="menuEvent($event, menuList.text)">
                            <label :for="'menu_list_' + menuList.name">{{ menuList.text }}</label>
                        </div>
                    </li>
                </ul>
            </div>
        </template>
    </div>
</template>
<script>
export default {
    name: "AlbaTalkNavigation",
    data() {
        return {
            check: false,
            menuLists: [
                {
                    name: 'all',
                    text: '전체'
                },
                {
                    name: 'seoul',
                    text: '서울'
                },
                {
                    name: 'gyeonggi',
                    text: '경기'
                },
                {
                    name: 'incheon',
                    text: '인천'
                },
                {
                    name: 'busan',
                    text: '부산'
                },
                {
                    name: 'daegu',
                    text: '대구'
                },
                {
                    name: 'daejeon',
                    text: '대전'
                },
                {
                    name: 'sejong',
                    text: '세종'
                },
                {
                    name: 'gwangju',
                    text: '광주'
                },
                {
                    name: 'ulsan',
                    text: '울산'
                },
                {
                    name: 'gangwon',
                    text: '강원'
                },
                {
                    name: 'geong_south',
                    text: '경남'
                },
                {
                    name: 'geong_north',
                    text: '경북'
                },
                {
                    name: 'jeon_south',
                    text: '전남'
                },
                {
                    name: 'jeon_north',
                    text: '전북'
                },
                {
                    name: 'chung_south',
                    text: '충남'
                },
                {
                    name: 'chung_north',
                    text: '충북'
                },
                {
                    name: 'jeju',
                    text: '제주'
                },
            ],
            checkLists: [],
        }
    },
    props: {
        'mobile': Boolean,
        'show': Boolean,
    },
    mounted() {
        document.getElementsByName("menu_list").forEach(x => {
            if(x.checked) {
                if (x.value != '전체') {
                    if (x.value == '세종') {
                        this.checkLists.push('세종특별자치시');
                    } else if (x.value == '제주') {
                        this.checkLists.push('제주특별자치도');
                    } else {
                        this.checkLists.push(x.value);
                    }
                }
            }
        });
        this.$emit('menuEventEmit', this.checkLists);
    },
    methods: {
        menuEvent(e, name) {
            if (e.target.checked) {
                if (name == '전체') {
                    document.getElementsByName("menu_list").forEach(x => {
                        if (x.value != '전체') {
                            x.checked = true;
                            if (x.value == '세종') {
                                this.checkLists.push('세종특별자치시');
                            } else if (x.value == '제주') {
                                this.checkLists.push('제주특별자치도');
                            } else {
                                this.checkLists.push(x.value);
                            }
                        }
                    });
                } else if (name == '세종') {
                    this.checkLists.push('세종특별자치시');
                } else if (name == '제주') {
                    this.checkLists.push('제주특별자치도');
                } else {
                    this.checkLists.push(name);
                }
            } else {
                if (name == '전체') {
                    this.checkLists = [];
                    document.getElementsByName("menu_list").forEach(x => {
                        x.checked = false;
                    });
                } else if (name == '세종') {
                    let index = this.checkLists.indexOf('세종특별자치시');
                    this.checkLists.splice(index, 1);
                } else if (name == '제주') {
                    let index = this.checkLists.indexOf('제주특별자치도');
                    this.checkLists.splice(index, 1);
                } else {
                    let index = this.checkLists.indexOf(name);
                    this.checkLists.splice(index, 1);
                }
            }
            let check_all = true;
            document.getElementsByName("menu_list").forEach(x => {
                if (x.value != '전체') {
                    check_all = check_all && x.checked;
                }
            });
            document.getElementById("menu_list_all").checked = check_all;

            const set = new Set(this.checkLists);
            const uniqueArr = [...set];

            this.$emit('menuEventEmit', uniqueArr);
        },

        mobileMenuEvent(e, name) {
            if (!e.target.classList.contains('active')) {
                if (name == '전체') {
                    document.querySelectorAll(".menu-list").forEach(x => {
                        x.classList.add('active');
                        if (x.getAttribute('data-name') != '전체') {
                            if (x.getAttribute('data-name') == '세종') {
                                this.checkLists.push('세종특별자치시');
                            } else if (x.getAttribute('data-name') == '제주') {
                                this.checkLists.push('제주특별자치도');
                            } else {
                                this.checkLists.push(x.getAttribute('data-name'));
                            }
                        }
                    });
                } else if (name == '세종') {
                    this.checkLists.push('세종특별자치시');
                } else if (name == '제주') {
                    this.checkLists.push('제주특별자치도');
                } else {
                    this.checkLists.push(name);
                }
                e.target.classList.add('active');
            } else {
                if (name == '전체') {
                    this.checkLists = [];
                    document.querySelectorAll(".menu-list").forEach(x => {
                        x.classList.remove('active');
                    });
                } else if (name == '세종') {
                    let index = this.checkLists.indexOf('세종특별자치시');
                    this.checkLists.splice(index, 1);
                } else if (name == '제주') {
                    let index = this.checkLists.indexOf('제주특별자치도');
                    this.checkLists.splice(index, 1);
                } else {
                    let index = this.checkLists.indexOf(name);
                    this.checkLists.splice(index, 1);
                }
                e.target.classList.remove('active');
            }

            let check_all = true;
            document.querySelectorAll(".menu-list").forEach(x => {
                if (x.getAttribute('data-name') != '전체') {
                    check_all = check_all && x.classList.contains('active');
                }
            });

            if (check_all) {
                document.getElementById("menu_list_all").classList.add('active');
            } else {
                document.getElementById("menu_list_all").classList.remove('active');
            }

            const set = new Set(this.checkLists);
            const uniqueArr = [...set];

            this.$emit('menuEventEmit', this.checkLists);
        },
        exit(){
            document.getElementById("albatalk-menu").style.display='none';
        }
    }
}
</script>

<style scoped>

</style>
