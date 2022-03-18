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
                                <label>전체</label>
                                <div class="second">
                                    <input type="checkbox" id="ulsan" name="ulsan">
                                    <label>울산</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Seoul" name="Seoul">
                                <label>서울</label>
                                <div class="second">
                                    <input type="checkbox" id="Gangwon" name="Gangwon">
                                    <label>강원</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Gyeonggi" name="Gyeonggi">
                                <label>경기</label>
                                <div class="second">
                                    <input type="checkbox" id="Gyeongnam" name="Gyeongnam">
                                    <label>경남</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Incheon" name="Incheon">
                                <label>인천</label>
                                <div class="second">
                                    <input type="checkbox" id="Gyeongbuk" name="Gyeongbuk">
                                    <label>경북</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Busan" name="Busan">
                                <label>부산</label>
                                <div class="second">
                                    <input type="checkbox" id="Jeonnam" name="Jeonnam">
                                    <label>전남</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Daegu" name="Daegu">
                                <label>대구</label>
                                <div class="second">
                                    <input type="checkbox" id="Jeonbuk" name="Jeonbuk">
                                    <label>전북</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Daejeon" name="Daejeon">
                                <label>대전</label>
                                <div class="second">
                                    <input type="checkbox" id="Chungnam" name="Chungnam">
                                    <label>충남</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Sejong" name="Sejong">
                                <label>세종</label>
                                <div class="second">
                                    <input type="checkbox" id="Chungbuk" name="Chungbuk">
                                    <label>충북</label>
                                </div>
                            </td>
                            <td class="all-wrap">
                                <input type="checkbox" id="Gwangju" name="Gwangju">
                                <label>광주</label>
                                <div class="second">
                                    <input type="checkbox" id="Jeju" name="Jeju">
                                    <label>제주</label>
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
