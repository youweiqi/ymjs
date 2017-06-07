<?php
namespace common\components;

use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

class GaoDe{
    const accessKey = GAODE_KEY;
    const districtUrl = GAODE_URL.'/config/district';
    const geoUrl = GAODE_URL.'/geocode/geo';
    /**
     * 通过地址获取经纬度
     * @param  array $parameters 请求的初始参数
     * @return mixed
     */
    public static function getGeo($parameters)
    {
        $parameters = ArrayHelper::merge($parameters,['key'=>self::accessKey]);
        $result = self::call($parameters,self::geoUrl);
        return $result;
    }
    /**
     * 行政区域查询
     * @param  array $parameters 请求的初始参数
     * @return mixed
     */
    public static function getDistrict($parameters)
    {
        $parameters = ArrayHelper::merge($parameters,['key'=>self::accessKey]);
        $result = self::call($parameters,self::districtUrl);
        return $result;
    }
    /**
     * 发起请求
     * @param  array $parameters 请求参数
     * @param  string $url 请求的URL地址
     * @param  string $type 发起请求的类型   get    post
     * @return mixed
     */
    public static function call($parameters,$url,$type='get')
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod($type)
            ->setUrl($url)
            ->setData($parameters)
            ->setOptions([
                CURLOPT_CONNECTTIMEOUT => 5, // connection timeout
                CURLOPT_TIMEOUT => 10, // data receiving timeout
            ])
            ->send();
        $responseData = $response->getData();
        return $responseData;
    }

}