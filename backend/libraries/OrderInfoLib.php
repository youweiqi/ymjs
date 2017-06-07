<?php
namespace backend\libraries;

use common\models\ExpressCompany;
use common\models\OrderInfo;

class OrderInfoLib{
    public static function processDelivery ($data)
    {
        
    }

    public static function getOrderInfo($id)

    {
        $order=OrderInfo::findOne($id);

        $order_info=$order->order_sn;

        return $order_info;

    }
    public  static function getPayType($pay_type)
    {
        switch ($pay_type)
        {
            case 1 :
                $pay_type_res = '微信支付';
                break;
            case 2 :
                $pay_type_res = '支付宝支付';
                break;
            case 3 :
                $pay_type_res = '公众号支付';
                break;
            default :
                $pay_type_res = '无';
                break;

        }
        return $pay_type_res;
    }

    public  static function getDeliveryWay($delivery_way)
    {
        switch ($delivery_way)
        {
            case 1 :
                $delivery_way_res = '及时送';
                break;
            case 2 :
                $delivery_way_res = '到店取';
                break;
            case 3 :
                $delivery_way_res = '快递送';
                break;
            default :
                $delivery_way_res = '快递送';
                break;
        }
        return $delivery_way_res;
    }


}