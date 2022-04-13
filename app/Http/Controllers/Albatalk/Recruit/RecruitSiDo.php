<?php

namespace App\Http\Controllers\Albatalk\Recruit;

class RecruitSiDo
{

    const seoul = '서울';
    const gyeonggi = '경기';
    const incheon = '인천';
    const busan = '부산';
    const daegu = '대구';
    const daejeon = '대전';
    const sejong = '세종특별자치시';
    const gwangju = '광주';
    const ulsan = '울산';
    const gangwon = '강원';
    const geong_south = '경남';
    const geong_north = '경북';
    const jeon_south = '전남';
    const jeon_north = '전북';
    const chung_south = '충남';
    const chung_north = '충북';
    const jeju = '제주특별자치도';

    public static function getArray()
    {
        return [
            self::seoul, self::gyeonggi, self::incheon, self::busan, self::daegu, self::daejeon, self::sejong, self::gwangju, self::ulsan,
            self::gangwon, self::geong_south, self::geong_north, self::jeon_south, self::jeon_north, self::chung_south, self::chung_north, self::jeju
        ];
    }

    private function __construct()
    {
    }
}
