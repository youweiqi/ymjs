<?php
namespace backend\libraries;

use common\components\Common;
use Yii;

class RefundLib
{
    /**
     * 处理售后退款
     * @param  string $afterSaleBn    售后单号
     * @param   int $money    退款金额
     * @return mixed
     */
    public static function processRefund($afterSaleBn,$money)
    {
        $url = YG_BASE_URL.API_REFUND_CASH;
        $params['afterSn'] = $afterSaleBn;
        $params['refundMoney'] = $money;
        $content = Common::requestServer($url, $params);
        return $result = json_decode($content,true);
    }




/*
 * 退运费
 * @param  $order_sn 父订单号
 */
    public static function processFreight($order_sn)
    {
        $url = YG_BASE_URL.API_REFUND_POSTAGE;
        $params['orderSn'] = $order_sn;
        $content = Common::requestServer($url, $params);
        return $result = json_decode($content,true);

    }
}