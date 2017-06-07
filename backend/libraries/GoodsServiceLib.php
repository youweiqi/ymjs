<?php
namespace backend\libraries;

use common\models\GoodsService;

class GoodsServiceLib
{
    /**
     * 根据ID字符串获取相关的data .例如 1,2
     * @param  string $goods_service_id_str
     * @return mixed
     */
    public static function getGoodsServiceData($goods_service_id_str)
    {
        $goods_service_data = [];
        $ids = explode(',', $goods_service_id_str);
        $goods_services = GoodsService::find()->where(['in','id',$ids])->asArray()->all();
        foreach ($goods_services as $goods_service)
        {
            $goods_service_data[$goods_service['id']] = $goods_service['name'];
        }
        return $goods_service_data;
    }
}