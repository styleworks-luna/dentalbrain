<template>
    <div class="albatalk-menu">
        <section class="wanted">
            <h2>구인정보</h2>
            <form>
                <div class="inquire-form-wrap">
                    <table>
                        <tr>
                            <th>근무지역</th>
                            <td class="all-wrap">
                                <input type="checkbox" id="all" name="all">
                                <label for="all">전체</label>
                                <div class="second">
                                    <input type="checkbox" id="ulsan" name="ulsan">
                                    <label for="ulsan">울산</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Seoul" name="Seoul">
                                <label for="Seoul">서울</label>
                                <div class="second">
                                    <input type="checkbox" id="Gangwon" name="Gangwon">
                                    <label for="Gangwon">강원</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Gyeonggi" name="Gyeonggi">
                                <label for="Gyeonggi">경기</label>
                                <div class="second">
                                    <input type="checkbox" id="Gyeongnam" name="Gyeongnam">
                                    <label for="Gyeongnam">경남</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Incheon" name="Incheon">
                                <label for="Incheon">인천</label>
                                <div class="second">
                                    <input type="checkbox" id="Gyeongbuk" name="Gyeongbuk">
                                    <label for="Gyeongbuk">경북</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Busan" name="Busan">
                                <label for="Busan">부산</label>
                                <div class="second">
                                    <input type="checkbox" id="Jeonnam" name="Jeonnam">
                                    <label for="Jeonnam">전남</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Daegu" name="Daegu">
                                <label for="Daegu">대구</label>
                                <div class="second">
                                    <input type="checkbox" id="Jeonbuk" name="Jeonbuk">
                                    <label for="Jeonbuk">전북</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Daejeon" name="Daejeon">
                                <label for="Daejeon">대전</label>
                                <div class="second">
                                    <input type="checkbox" id="Chungnam" name="Chungnam">
                                    <label for="Chungnam">충남</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Sejong" name="Sejong">
                                <label for="Sejong">세종</label>
                                <div class="second">
                                    <input type="checkbox" id="Chungbuk" name="Chungbuk">
                                    <label for="Chungbuk">충북</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Gwangju" name="Gwangju">
                                <label for="Gwangju">광주</label>
                                <div class="second">
                                    <input type="checkbox" id="Jeju" name="Jeju">
                                    <label for="Jeju">제주</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </section>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkNavigation",
}
</script>

<style scoped>

</style>
