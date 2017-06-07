<?php
namespace backend\libraries;

use common\components\Common;
use Yii;

class RefundLib
{
    /**
     * 处理售后退款
     * @param  string $afterSaleBn    售后单号
     * @param  integer $refundMoney    退款金额
     * @return mixed
     */
    public static function processRefund($afterSaleBn,$refundMoney=0)
    {
        $url = Yii::$app->params['apiBaseUrl'].Yii::$app->params['apiRefundCash'];
        if($refundMoney){
            $params['refundMoney'] = $refundMoney;
        }
        $params['afterSn'] = $afterSaleBn;
        $content = Common::requestServer($url, $params);
        $result = json_decode($content,true);
        if($result['code']==10000){
            Yii::$app->session->setFlash('success',$result['message']);
            return true;
        }else{
            Yii::$app->session->setFlash('error',$result['message']);
            return false;
        }
    }

    public static function processFreight($order_sn)
    {
        return false;
    }

}