<?php
namespace backend\libraries;

use common\components\QiNiu;
use common\models\GoodsDetail;


class GoodsDetailLib
{
    /**
     * 根据原来数据的数组删除商品详情图（七牛云上的图片也进行删除）.
     * @param  array $goods_details
     */
    public static function delGoodsDetails($goods_details)
    {
        $ids = [];
        foreach ($goods_details as $goods_detail)
        {
            QiNiu::deleteFile($goods_detail['image_path']);
            $ids[] = $goods_detail['id'];
        }
        if(is_array($ids) && !empty($ids)){
            GoodsDetail::deleteAll(['in', 'id', $ids]);
        }

    }
}