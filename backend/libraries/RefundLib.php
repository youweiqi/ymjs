<?php
namespace backend\libraries;

use common\components\Common;
use Yii;

class RefundLib
{
    /**
     * 处理售后退款
     * @param  string $afterSaleBn    售后单号
     * @return mixed
     */
    public static function processFreight($afterSaleBn)
    {
        $url = YG_BASE_URL.API_REFUND_CASH;
        $params['afterSn'] = $afterSaleBn;
        $content = Common::requestServer($url, $params);
        return $result = json_decode($content,true);

    }
}