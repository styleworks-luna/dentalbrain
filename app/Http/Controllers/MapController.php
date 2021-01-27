<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MapController extends Controller
{
    /**
     * @param Request $request
     * @return bool|string
     */
    public function naver_map(Request $request)
    {
        $VARS = $request;
        $query = [];
        $url = isset($VARS->url) ? $VARS["url"] : NULL;
        $headerArray = array();

        switch ($url) {
            case 'openapi.naver.com/v1/search/local':
                if (isset($VARS['output']) && $VARS['output'] == 'json') {
                    $headerArray[] = 'Accept: application/json';
                } else {
                    $query['output'] = 'xml';
                    $headerArray[] = 'Accept: application/xml';
                }
                $url = 'https://' . $url . '.' . $VARS['output'];
                $query['query'] = isset($VARS['query']) && !empty($VARS['query']) ? $VARS['query'] : '';
                $query['display'] = 5;

                $headerArray[] = 'X-Naver-Client-Id: ' . env('NAVER_DEV_ID');
                $headerArray[] = 'X-Naver-Client-Secret: ' . env('NAVER_DEV_SECRET');
                break;
            case 'naveropenapi.apigw.ntruss.com/map-geocode/v2/geocode': // 네이버 주소 검색 v3
                $url = 'https://' . $url;
                $query['query'] = isset($VARS['query']) && !empty($VARS['query']) ? $VARS['query'] : '';
                $query['count'] = isset($VARS['count']) && !empty($VARS['count']) ? $VARS['count'] : 10;
                $headerArray[] = 'X-NCP-APIGW-API-KEY-ID: ' . env('NAVER_CLOUD_ID');
                $headerArray[] = 'X-NCP-APIGW-API-KEY: ' . env('NAVER_CLOUD_SECRET');
                $headerArray[] = 'Content-Type: application/json';
                break;
            default:
                echo '허가되지 않은 PROXY URL';
                exit;
        }

        if (strpos($url, '://') === false)
            $url = 'http://' . $url;

        unset($VARS['url'], $VARS['method']);
        $paraArray = array();
        foreach ($query as $key => $val) {
            $paraArray[$key] = $val;
        }

        $parameter = http_build_query($paraArray);
        $url .= '?' . $parameter;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!empty($headerArray)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
        }
        $data = curl_exec($ch);
        if ($data === false) {
            Log::error('MAP FAILED', [curl_error($ch)]);
            Log::error("MAP FAILED NUM :", [curl_errno($ch)]);
        }
        curl_close($ch);

        return $data;
    }

    /**
     * @param Request $request
     * @return bool|string
     */
    public function reverse_geocode(Request $request)
    {
        $args = ['coords' => $request->latlng, 'output' => 'json', 'orders' => 'addr'];
        $url = "https://naveropenapi.apigw.ntruss.com/map-reversegeocode/v2/gc?" . http_build_query($args); // json
        $is_post = false;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $headers[] = "X-NCP-APIGW-API-KEY-ID: " . env('NAVER_CLOUD_ID');
        $headers[] = "X-NCP-APIGW-API-KEY: " . env('NAVER_CLOUD_SECRET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($status_code == 200) {
            return $response;
        } else {
            return "Error 내용:" . $response;
        }
    }
}
